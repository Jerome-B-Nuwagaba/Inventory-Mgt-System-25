<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::with(['product', 'warehouse'])
            ->whereHas('warehouse', function ($query) {
                $query->where('manager_id', Auth::id());
            })
            ->get();
        return response()->json($inventory);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:0',
            'location' => 'required|string',
            'condition' => 'required|string|in:new,used,damaged',
            'minimum_stock_level' => 'required|integer|min:0',
            'maximum_stock_level' => 'required|integer|min:0|gt:minimum_stock_level',
            'notes' => 'nullable|string',
        ]);

        $warehouse = Warehouse::findOrFail($validated['warehouse_id']);
        $this->authorize('manage', $warehouse);

        $inventory = Inventory::create([
            ...$validated,
            'last_checked_at' => now(),
        ]);

        // Update warehouse utilization
        $warehouse->update([
            'current_utilization' => $warehouse->current_utilization + $validated['quantity'],
        ]);

        return response()->json($inventory, 201);
    }

    public function show(Inventory $inventory)
    {
        $this->authorize('view', $inventory);
        return response()->json($inventory->load(['product', 'warehouse']));
    }

    public function update(Request $request, Inventory $inventory)
    {
        $this->authorize('update', $inventory);

        $validated = $request->validate([
            'quantity' => 'sometimes|integer|min:0',
            'location' => 'sometimes|string',
            'condition' => 'sometimes|string|in:new,used,damaged',
            'minimum_stock_level' => 'sometimes|integer|min:0',
            'maximum_stock_level' => 'sometimes|integer|min:0|gt:minimum_stock_level',
            'notes' => 'nullable|string',
        ]);

        if (isset($validated['quantity'])) {
            $quantityDiff = $validated['quantity'] - $inventory->quantity;
            $warehouse = $inventory->warehouse;
            
            // Update warehouse utilization
            $warehouse->update([
                'current_utilization' => $warehouse->current_utilization + $quantityDiff,
            ]);
        }

        $inventory->update([
            ...$validated,
            'last_checked_at' => now(),
        ]);

        return response()->json($inventory);
    }

    public function checkLowStock()
    {
        $lowStockItems = Inventory::with(['product', 'warehouse'])
            ->whereHas('warehouse', function ($query) {
                $query->where('manager_id', Auth::id());
            })
            ->whereRaw('quantity <= minimum_stock_level')
            ->get();

        return response()->json($lowStockItems);
    }

    public function checkOverstocked()
    {
        $overstockedItems = Inventory::with(['product', 'warehouse'])
            ->whereHas('warehouse', function ($query) {
                $query->where('manager_id', Auth::id());
            })
            ->whereRaw('quantity >= maximum_stock_level')
            ->get();

        return response()->json($overstockedItems);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('manager')
            ->where('manager_id', Auth::id())
            ->get();
        return response()->json($warehouses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'contact_number' => 'required|string',
            'address' => 'required|string',
        ]);

        $warehouse = Warehouse::create([
            ...$validated,
            'manager_id' => Auth::id(),
            'current_utilization' => 0,
            'status' => 'active',
        ]);

        return response()->json($warehouse, 201);
    }

    public function show(Warehouse $warehouse)
    {
        $this->authorize('view', $warehouse);
        return response()->json($warehouse->load('manager'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $this->authorize('update', $warehouse);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string',
            'capacity' => 'sometimes|integer|min:1',
            'contact_number' => 'sometimes|string',
            'address' => 'sometimes|string',
            'status' => 'sometimes|string|in:active,inactive,maintenance',
        ]);

        $warehouse->update($validated);

        return response()->json($warehouse);
    }

    public function getUtilization(Warehouse $warehouse)
    {
        $this->authorize('view', $warehouse);
        
        return response()->json([
            'warehouse' => $warehouse,
            'utilization_percentage' => $warehouse->getUtilizationPercentage(),
            'available_space' => $warehouse->capacity - $warehouse->current_utilization,
        ]);
    }

    public function getInventory(Warehouse $warehouse)
    {
        $this->authorize('view', $warehouse);
        
        return response()->json($warehouse->inventory()->with('product')->get());
    }
} 
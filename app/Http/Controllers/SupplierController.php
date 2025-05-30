<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawMaterial;
use App\Models\Delivery;
use App\Models\Manufacturer;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function addRawMaterial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        $rawMaterial = RawMaterial::create([
            'name' => $validated['name'],
            'quantity' => $validated['quantity'],
            'supplier_id' => Auth::id(), // assuming supplier is authenticated
        ]);

        return response()->json([
            'message' => 'Raw material added successfully.',
            'data' => $rawMaterial
        ], 201);
    }

    /**
     * Deliver raw materials to a manufacturer
     */
    public function deliverRawMaterial(Request $request)
    {
        $validated = $request->validate([
            'raw_material_id' => 'required|exists:raw_materials,id',
            'manufacturer_id' => 'required|exists:manufacturers,id',
            'quantity' => 'required|integer|min:1',
            'delivery_date' => 'required|date'
        ]);

        $rawMaterial = RawMaterial::where('id', $validated['raw_material_id'])
            ->where('supplier_id', Auth::id())
            ->first();

        if (!$rawMaterial) {
            return response()->json(['error' => 'Raw material not found or unauthorized.'], 403);
        }

        if ($rawMaterial->quantity < $validated['quantity']) {
            return response()->json(['error' => 'Insufficient stock to deliver.'], 400);
        }

        // Deduct stock
        $rawMaterial->quantity -= $validated['quantity'];
        $rawMaterial->save();

        // Record delivery
        $delivery = Delivery::create([
            'raw_material_id' => $validated['raw_material_id'],
            'manufacturer_id' => $validated['manufacturer_id'],
            'quantity' => $validated['quantity'],
            'delivery_date' => $validated['delivery_date'],
            'status' => 'delivered',
        ]);

        return response()->json([
            'message' => 'Delivery recorded successfully.',
            'data' => $delivery
        ]);
    }

    /**
     * View deliveries made by the supplier
     */
    public function myDeliveries()
    {
        $deliveries = Delivery::with(['rawMaterial', 'manufacturer'])
            ->whereHas('rawMaterial', function ($query) {
                $query->where('supplier_id', Auth::id());
            })
            ->orderBy('delivery_date', 'desc')
            ->get();

        return response()->json($deliveries);
    }
}

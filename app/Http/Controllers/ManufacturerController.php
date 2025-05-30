<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RawMaterialChecklist;
use App\Models\Delivery;
use App\Models\Production;
use App\Models\Warehouse;
use App\Models\ProductionStage;
use App\Models\ProductionBatch;
use App\Models\Car;

class ManufacturerController extends Controller
{
    public function createChecklist(Request $request)
    {
        $validated = $request->validate([
            'materials' => 'required|array',
            'materials.*.name' => 'required|string',
            'materials.*.required_quantity' => 'required|integer|min:1',
        ]);

        foreach ($validated['materials'] as $item) {
            RawMaterialChecklist::create([
                'manufacturer_id' => Auth::id(),
                'raw_material_name' => $item['name'],
                'required_quantity' => $item['required_quantity'],
                'delivered_quantity' => 0,
            ]);
        }

        return response()->json(['message' => 'Checklist created successfully']);
    }

    public function checklistStatus()
    {
        $checklist = RawMaterialChecklist::where('manufacturer_id', Auth::id())->get();
        return response()->json($checklist);
    }

    public function startProduction(Request $request)
    {
        $validated = $request->validate([
            'car_name' => 'required|string',
            'model' => 'required|string',
        ]);

        $checklist = RawMaterialChecklist::where('manufacturer_id', Auth::id())->get();

        foreach ($checklist as $item) {
            if ($item->delivered_quantity < $item->required_quantity) {
                return response()->json([
                    'error' => 'Cannot start production. Not all materials are delivered.'
                ], 400);
            }
        }

        // Create a new production batch
        $batch = ProductionBatch::create([
            'manufacturer_id' => Auth::id(),
            'car_name' => $validated['car_name'],
            'model' => $validated['model'],
            'current_stage' => 'Frame',
            'is_completed' => false
        ]);

        // Start first production stage
        ProductionStage::create([
            'production_batch_id' => $batch->id,
            'stage_name' => 'Frame',
            'started_at' => now(),
        ]);

        return response()->json([
            'message' => 'Production batch started.',
            'data' => $batch
        ]);
    }

    public function advanceProductionStage($batchId)
    {
        $batch = ProductionBatch::where('id', $batchId)
            ->where('manufacturer_id', Auth::id())
            ->firstOrFail();

        $stages = ['Frame', 'Engine', 'Interior', 'Paint', 'Quality Check', 'Completed'];
        $currentIndex = array_search($batch->current_stage, $stages);

        if ($currentIndex === false || $currentIndex >= count($stages) - 1) {
            return response()->json(['message' => 'Production already completed.']);
        }

        // Close previous stage
        $currentStage = ProductionStage::where('production_batch_id', $batch->id)
            ->where('stage_name', $batch->current_stage)
            ->latest()
            ->first();

        if ($currentStage) {
            $currentStage->ended_at = now();
            $currentStage->save();
        }

        // Advance to next stage
        $nextStage = $stages[$currentIndex + 1];
        $batch->current_stage = $nextStage;
        if ($nextStage === 'Completed') {
            $batch->is_completed = true;
        }
        $batch->save();

        // Create next stage entry
        ProductionStage::create([
            'production_batch_id' => $batch->id,
            'stage_name' => $nextStage,
            'started_at' => now(),
        ]);

        return response()->json([
            'message' => 'Production advanced.',
            'current_stage' => $nextStage
        ]);
    }

    public function sendToWarehouse(Request $request, $batchId)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id'
        ]);

        $batch = ProductionBatch::where('id', $batchId)
            ->where('manufacturer_id', Auth::id())
            ->where('is_completed', true)
            ->firstOrFail();

        $warehouse = Warehouse::find($validated['warehouse_id']);

        if ($warehouse->capacity <= $warehouse->cars()->count()) {
            return response()->json(['error' => 'Warehouse is full.'], 400);
        }

        // Send car to warehouse
        Car::create([
            'name' => $batch->car_name,
            'model' => $batch->model,
            'warehouse_id' => $warehouse->id,
            'manufacturer_id' => Auth::id()
        ]);

        return response()->json(['message' => 'Car sent to warehouse.']);
    }
}

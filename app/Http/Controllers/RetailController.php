<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retailer;
use App\Models\Shipment;
use App\Models\Car;
use App\Models\Purchase;


class RetailController extends Controller
{
    public function receiveShipment(Request $request)
    {
        $validated = $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
            'condition' => 'required|string',
            'received_date' => 'required|date',
        ]);

        $shipment = Shipment::findOrFail($validated['shipment_id']);

        if ($shipment->status !== 'Delivered') {
            return response()->json(['error' => 'Shipment not delivered yet. Cannot receive.'], 400);
        }

        // Record car condition and receipt at retailer
        $car = $shipment->car;
        $car->condition = $validated['condition'];
        $car->retailer_id = $shipment->retailer_id;
        $car->received_date = $validated['received_date'];
        $car->save();

        return response()->json(['message' => 'Shipment received and recorded at retailer.', 'car' => $car]);
    }

    /**
     * Record customer purchase
     */
    public function recordPurchase(Request $request)
    {
        $validated = $request->validate([
            'retailer_id' => 'required|exists:retailers,id',
            'car_id' => 'required|exists:cars,id',
            'customer_name' => 'required|string',
            'purchase_date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $car = Car::findOrFail($validated['car_id']);
        if ($car->sold) {
            return response()->json(['error' => 'Car already sold.'], 400);
        }

        // Mark car as sold
        $car->sold = true;
        $car->save();

        $purchase = Purchase::create([
            'retailer_id' => $validated['retailer_id'],
            'car_id' => $validated['car_id'],
            'customer_name' => $validated['customer_name'],
            'purchase_date' => $validated['purchase_date'],
            'price' => $validated['price'],
        ]);

        return response()->json(['message' => 'Purchase recorded successfully.', 'purchase' => $purchase]);
    }
}

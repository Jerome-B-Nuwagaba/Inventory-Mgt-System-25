<?php

namespace App\Http\Controllers\Manufacturer;

use App\Http\Controllers\Controller;
use App\Models\ProductionLine;
use App\Models\Product;
use App\Models\RetailerOrder;
use Illuminate\Http\Request;

class ProductionLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productionLines = ProductionLine::with(['product', 'retailerOrder'])->get();
        $products = Product::all();
        $retailerOrders = RetailerOrder::all();
        return view('dashboards.manufacturer.production-lines', compact('productionLines', 'products', 'retailerOrders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'throughput' => 'required|integer',
            'product_id' => 'nullable|exists:products,id',
            'retailer_order_id' => 'nullable|exists:retailer_orders,id',
        ]);

        ProductionLine::create($request->all());

        return redirect()->route('manufacturer.production-lines')
            ->with('success', 'Production line created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'throughput' => 'required|integer',
            'status' => 'required|string|max:255',
            'product_id' => 'nullable|exists:products,id',
            'retailer_order_id' => 'nullable|exists:retailer_orders,id',
            'current_stage' => 'nullable|string|max:255',
            'failed_reason' => 'nullable|string|max:255',
        ]);

        $productionLine = ProductionLine::find($id);
        $productionLine->update($request->all());

        return redirect()->route('manufacturer.production-lines')
            ->with('success', 'Production line updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $productionLine = ProductionLine::find($id);
        $productionLine->delete();

        return redirect()->route('manufacturer.production-lines')
            ->with('success', 'Production line deleted successfully');
    }
}

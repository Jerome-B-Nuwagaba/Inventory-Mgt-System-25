<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;

class RetailerController extends Controller
{
    public function dashboard()
    {
        $products = Product::all();
        $totalSales = Sale::where('retailer_id', auth()->id())->sum('amount');
        return view('retailer.dashboard', compact('products', 'totalSales'));
    }

    public function purchaseProduct(Product $product)
    {
        return view('retailer.purchase_product', compact('product'));
    }

    public function processPurchase(Request $request, Product $product)
    {
        // Logic to process the purchase
        return redirect()->route('retailer.dashboard')->with('success', 'Product purchased successfully.');
    }
} 
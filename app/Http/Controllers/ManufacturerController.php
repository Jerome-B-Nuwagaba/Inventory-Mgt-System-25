<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ManufacturerController extends Controller
{
    public function dashboard()
    {
        $products = Product::where('manufacturer_id', auth()->id())->get();
        return view('manufacturer.dashboard', compact('products'));
    }

    public function editProduct(Product $product)
    {
        return view('manufacturer.edit_product', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('manufacturer.dashboard')->with('success', 'Product updated successfully.');
    }
} 
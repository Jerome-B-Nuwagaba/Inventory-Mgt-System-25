<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('manufacturer')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'specifications' => 'nullable|array',
            'production_stage' => 'required|string|in:frame,engine,interior,paint,quality_check',
        ]);

        $product = Product::create([
            ...$validated,
            'manufacturer_id' => Auth::id(),
            'status' => 'available',
        ]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load('manufacturer'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'model' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'specifications' => 'nullable|array',
            'production_stage' => 'sometimes|string|in:frame,engine,interior,paint,quality_check',
            'status' => 'sometimes|string|in:available,out_of_stock,discontinued',
        ]);

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return response()->json(null, 204);
    }

    public function updateProductionStage(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'production_stage' => 'required|string|in:frame,engine,interior,paint,quality_check',
        ]);

        $product->update($validated);

        return response()->json($product);
    }
} 
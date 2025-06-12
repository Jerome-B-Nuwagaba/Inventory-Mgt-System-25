<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;

class ConsumerController extends Controller
{
    public function dashboard()
    {
        $products = Product::where('status', 'available')->paginate(6);
        $orders = Order::where('buyer_id', auth()->id())
            ->with('item')
            ->latest()
            ->paginate(5);
        $totalOrders = Order::where('buyer_id', auth()->id())->count();
        $pendingOrders = Order::where('buyer_id', auth()->id())->where('status', 'pending')->count();
        $completedOrders = Order::where('buyer_id', auth()->id())->where('status', 'completed')->count();
        return view('consumer.dashboard', compact('products', 'orders', 'totalOrders', 'pendingOrders', 'completedOrders'));
    }

    public function products()
    {
        $products = Product::where('status', 'available')
            ->with(['manufacturer'])
            ->paginate(10);
        return view('consumer.products', compact('products'));
    }

    public function showProduct(Product $product)
    {
        return view('consumer.products.show', compact('product'));
    }

    public function orders()
    {
        $orders = Order::where('buyer_id', auth()->id())
            ->with(['seller', 'item'])
            ->paginate(10);
        return view('consumer.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $this->authorize('view', $order);
        return view('consumer.orders.show', compact('order'));
    }

    public function createOrder(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'delivery_address' => 'required|string',
            'delivery_date' => 'required|date|after:today',
        ]);

        $order = Order::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $product->manufacturer_id,
            'item_type' => 'car',
            'item_id' => $product->id,
            'quantity' => $request->quantity,
            'status' => 'pending',
            'delivery_address' => $request->delivery_address,
            'delivery_date' => $request->delivery_date,
        ]);

        return redirect()->route('consumer.orders.show', $order)
            ->with('success', 'Order placed successfully!');
    }

    public function cancelOrder(Order $order)
    {
        $this->authorize('update', $order);
        
        if ($order->status === 'pending') {
            $order->update(['status' => 'cancelled']);
            return redirect()->route('consumer.orders')
                ->with('success', 'Order cancelled successfully!');
        }

        return back()->with('error', 'Cannot cancel order in current status.');
    }

    public function trackOrder(Order $order)
    {
        $this->authorize('view', $order);
        return view('consumer.orders.track', compact('order'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('consumer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));

        return redirect()->route('consumer.profile')
            ->with('success', 'Profile updated successfully!');
    }
} 
<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\MessageLogger;

class OrderController extends Controller
{
    protected $messageLogger;

    public function __construct(MessageLogger $messageLogger)
    {
        $this->messageLogger = $messageLogger;
    }

    public function index()
    {
        $orders = Order::with(['product', 'buyer', 'seller'])
            ->where('buyer_id', Auth::id())
            ->orWhere('seller_id', Auth::id())
            ->get();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        $order = Order::create([
            'order_number' => 'ORD-' . Str::random(10),
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'buyer_id' => Auth::id(),
            'seller_id' => $product->manufacturer_id,
            'status' => 'pending',
            'total_amount' => $product->price * $validated['quantity'],
            'shipping_address' => $validated['shipping_address'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return response()->json($order->load(['product', 'buyer', 'seller']));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered',
            'tracking_number' => 'required_if:status,shipped|nullable|string',
        ]);

        $order->update($validated);

        // Notify the other party about the status change
        // TODO: Implement notification system

        return response()->json($order);
    }

    public function getOrderChat(Order $order)
    {
        $this->authorize('view', $order);
        return response()->json($order->chatMessages()->with(['sender', 'receiver'])->get());
    }

    public function sendMessage(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $receiverId = Auth::id() === $order->buyer_id ? $order->seller_id : $order->buyer_id;

        $chatMessage = $order->chatMessages()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $validated['message'],
        ]);

        // Log the message
        $this->messageLogger->logMessage(
            $order->id,
            Auth::id(),
            $receiverId,
            $validated['message']
        );

        return response()->json($chatMessage->load(['sender', 'receiver']));
    }
} 
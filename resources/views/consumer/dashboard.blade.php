@extends('layouts.dashboard')

@section('title', 'Consumer Dashboard')
@section('description', 'Welcome back, ' . auth()->user()->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Orders -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Total Orders</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Pending Orders</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $pendingOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Completed Orders -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Completed Orders</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $completedOrders }}</p>
            </div>
        </div>
    </div>

    <!-- Available Products -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-sm font-medium text-gray-600">Available Products</h2>
                <p class="text-2xl font-semibold text-gray-900">{{ $products->total() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900">Recent Orders</h2>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-4 py-3">Order ID</th>
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-3">
                            <span class="text-sm font-medium text-gray-900">#{{ $order->id }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-900">{{ $order->item->name }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'completed') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('consumer.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View Details</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-center text-sm text-gray-500">
                            No orders found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Available Products -->
<div class="mt-8 bg-white rounded-xl shadow-sm">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-semibold text-gray-900">Available Products</h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $product->name }}</h3>
                    <p class="mt-1 text-sm text-gray-500">{{ Str::limit($product->description, 100) }}</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('consumer.products.show', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-sm text-gray-500">
                No products available
            </div>
            @endforelse
        </div>
        @if($products->hasPages())
        <div class="mt-6">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 
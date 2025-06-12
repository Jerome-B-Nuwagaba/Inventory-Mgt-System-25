@extends('layouts.dashboard')

@section('title', 'My Orders')
@section('description', 'View your order history')

@section('content')
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
@endsection 
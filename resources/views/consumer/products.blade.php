@extends('layouts.dashboard')

@section('title', 'Available Products')
@section('description', 'Browse our available products')

@section('content')
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
@endsection 
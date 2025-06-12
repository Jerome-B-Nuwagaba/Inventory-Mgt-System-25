@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Retailer Dashboard</h1>
    
    <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-white mb-4">Available Products</h2>
        <ul class="divide-y divide-gray-700">
            @foreach($products as $product)
                <li class="py-4">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-sm font-medium text-white">{{ $product->name }}</p>
                            <p class="text-sm text-gray-400">Price: ${{ $product->price }}</p>
                        </div>
                        <div>
                            <a href="{{ route('products.purchase', $product) }}" class="text-blue-500 hover:text-blue-700">Purchase</a>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    
    <div class="bg-gray-800 shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4">Sales Statistics</h2>
        <p class="text-sm text-gray-400">Total Sales: ${{ $totalSales }}</p>
        <a href="{{ route('sales.index') }}" class="bg-blue-900 hover:bg-blue-950 text-white font-bold py-2 px-4 rounded-full inline-flex items-center transition duration-300 ease-in-out transform hover:scale-105">
            View Sales
        </a>
    </div>
    
    <div class="bg-gray-800 shadow-lg rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold text-white mb-4">Chat</h2>
        <a href="{{ route('chats.index') }}" class="bg-blue-900 hover:bg-blue-950 text-white font-bold py-2 px-4 rounded-full inline-flex items-center transition duration-300 ease-in-out transform hover:scale-105">
            Go to Chat
        </a>
    </div>
</div>
@endsection 
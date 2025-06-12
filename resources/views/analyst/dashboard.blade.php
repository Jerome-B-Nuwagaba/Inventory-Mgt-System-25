@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-white mb-6">Analyst Dashboard</h1>
    
    <div class="bg-gray-800 shadow-lg rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-white mb-4">Analytics Overview</h2>
        <p class="text-sm text-gray-400">Total Sales: ${{ $totalSales }}</p>
        <p class="text-sm text-gray-400">Total Products: {{ $totalProducts }}</p>
        <p class="text-sm text-gray-400">Total Customers: {{ $totalCustomers }}</p>
    </div>
    
    <div class="bg-gray-800 shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-white mb-4">Reports</h2>
        <a href="{{ route('reports.generate') }}" class="bg-blue-900 hover:bg-blue-950 text-white font-bold py-2 px-4 rounded-full inline-flex items-center transition duration-300 ease-in-out transform hover:scale-105">
            Generate Reports
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
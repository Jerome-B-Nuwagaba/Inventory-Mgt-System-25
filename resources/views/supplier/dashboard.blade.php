@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-gray-700">
    <!-- Hero Section -->
    <div class="relative">
        <img src="https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1500&q=80" alt="Automotive Hero" class="w-full h-64 object-cover opacity-70 rounded-b-3xl shadow-lg">
        <div class="absolute inset-0 flex flex-col justify-center items-center text-white bg-black bg-opacity-40 rounded-b-3xl">
            <svg class="w-24 h-24 mb-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                <rect x="6" y="20" width="36" height="12" rx="6" stroke-width="2.5"/>
                <circle cx="14" cy="36" r="4" stroke-width="2.5"/>
                <circle cx="34" cy="36" r="4" stroke-width="2.5"/>
                <rect x="18" y="14" width="12" height="8" rx="2" stroke-width="2.5"/>
            </svg>
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight drop-shadow-lg">Supplier Dashboard</h1>
            <p class="mt-2 text-lg md:text-xl text-indigo-200 font-medium drop-shadow">Welcome, {{ auth()->user()->name }}! Drive your supply chain forward.</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="max-w-7xl mx-auto px-4 -mt-16 z-10 relative">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex items-center space-x-4 border-t-4 border-indigo-500">
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div>
                    <div class="text-gray-600 text-sm font-semibold">Active Orders</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $activeOrders ?? 0 }}</div>
                </div>
            </div>
            <div class="bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex items-center space-x-4 border-t-4 border-green-500">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <div class="text-gray-600 text-sm font-semibold">Parts in Stock</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $partsInStock ?? 0 }}</div>
                </div>
            </div>
            <div class="bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex items-center space-x-4 border-t-4 border-yellow-500">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-gray-600 text-sm font-semibold">Pending Deliveries</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $pendingDeliveries ?? 0 }}</div>
                </div>
            </div>
            <div class="bg-white bg-opacity-90 rounded-2xl shadow-xl p-6 flex items-center space-x-4 border-t-4 border-purple-500">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="text-gray-600 text-sm font-semibold">On-Time Delivery</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $onTimeDelivery ?? 0 }}%</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Recent Orders -->
            <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-indigo-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h4"/></svg>Recent Orders</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Order ID</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Part</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Due Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentOrders ?? [] as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->part_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                           ($order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->due_date }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No recent orders</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Inventory Status -->
            <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-green-900 mb-6 flex items-center"><svg class="w-6 h-6 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>Inventory Status</h2>
                <div class="space-y-4">
                    @forelse($inventory ?? [] as $item)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg shadow-sm">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">{{ $item->name }}</h3>
                            <p class="text-xs text-gray-500">SKU: {{ $item->sku }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-base font-bold text-gray-900">{{ $item->quantity }} units</p>
                            <p class="text-xs text-gray-500">Reorder at: {{ $item->reorder_point }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-sm text-gray-500">No inventory items found</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
                <h3 class="text-lg font-bold text-indigo-700 mb-4 flex items-center"><svg class="w-5 h-5 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Delivery Performance</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">On-Time Delivery</span>
                        <span class="text-sm font-bold text-green-600">{{ $onTimeDelivery ?? 0 }}%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Late Deliveries</span>
                        <span class="text-sm font-bold text-red-600">{{ $lateDeliveries ?? 0 }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
                <h3 class="text-lg font-bold text-blue-700 mb-4 flex items-center"><svg class="w-5 h-5 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>Quality Metrics</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Quality Score</span>
                        <span class="text-sm font-bold text-blue-600">{{ $qualityScore ?? 0 }}%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Returns Rate</span>
                        <span class="text-sm font-bold text-yellow-600">{{ $returnsRate ?? 0 }}%</span>
                    </div>
                </div>
            </div>
            <div class="bg-white bg-opacity-95 rounded-2xl shadow-lg p-8">
                <h3 class="text-lg font-bold text-purple-700 mb-4 flex items-center"><svg class="w-5 h-5 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Cost Metrics</h3>
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Cost Variance</span>
                        <span class="text-sm font-bold text-purple-600">{{ $costVariance ?? 0 }}%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Price Competitiveness</span>
                        <span class="text-sm font-bold text-indigo-600">{{ $priceCompetitiveness ?? 0 }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
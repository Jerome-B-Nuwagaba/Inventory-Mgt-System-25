@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-8">
                <h1 class="text-3xl font-bold text-white mb-2">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100">Manage your automotive supply chain system efficiently</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Total Users</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Suppliers -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Total Suppliers</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalSuppliers }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Inventory -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Total Inventory</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalInventory }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h2 class="text-gray-600 text-sm">Total Orders</h2>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('users.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span class="text-gray-700">Manage Users</span>
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="text-gray-700">View Inventory</span>
                </a>
                <a href="{{ route('chats.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="text-gray-700">Chat System</span>
                </a>
                <a href="{{ route('reports.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-gray-700">View Reports</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent User Registrations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent User Registrations</h2>
                <div class="space-y-4">
                    @forelse($recentUsers as $user)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $user->created_at ? $user->created_at->diffForHumans() : 'N/A' }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent user registrations</p>
                    @endforelse
                </div>
            </div>

            <!-- System Notifications -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">System Notifications</h2>
                <div class="space-y-4">
                    @forelse($notifications as $notification)
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">{{ $notification->title ?? 'No Title' }}</p>
                                <p class="text-sm text-gray-500">{{ $notification->message ?? 'No Message' }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at ? $notification->created_at->diffForHumans() : 'N/A' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No new notifications</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Orders and Low Stock -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Recent Orders</h2>
                <div class="space-y-4">
                    @forelse($recentOrders as $order)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="text-green-600 font-semibold">#{{ $order->id }}</span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $order->buyer->name ?? 'Unknown' }} → {{ $order->seller->name ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">{{ $order->created_at ? $order->created_at->diffForHumans() : 'N/A' }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No recent orders</p>
                    @endforelse
                </div>
            </div>

            <!-- Low Stock Items -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Low Stock Items</h2>
                <div class="space-y-4">
                    @forelse($lowStockItems as $item)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <span class="text-red-600 font-semibold">!</span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $item->name ?? 'Unnamed Item' }}</p>
                                    <p class="text-sm text-gray-500">Quantity: {{ $item->quantity ?? 0 }}</p>
                                </div>
                            </div>
                            <a href="{{ route('inventory.edit', $item) }}" class="text-sm text-blue-600 hover:text-blue-800">Restock</a>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No low stock items</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
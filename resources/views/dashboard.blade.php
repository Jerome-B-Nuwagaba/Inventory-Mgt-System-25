<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <h1 class="text-xl font-bold">Supply Chain System</h1>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if(auth()->user()->role === 'admin')
                    <!-- Admin Dashboard -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">User Management</h3>
                                    <p class="text-gray-600">Manage users and permissions</p>
                                </a>
                                <a href="{{ route('inventory.index') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Inventory Overview</h3>
                                    <p class="text-gray-600">Monitor system-wide inventory</p>
                                </a>
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Reports</h3>
                                    <p class="text-gray-600">View system analytics and reports</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Interface -->
                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">Chat</h2>
                            <chat-interface 
                                :order-id="null"
                                :receiver-id="null"
                            ></chat-interface>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'supplier')
                    <!-- Supplier Dashboard -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">Supplier Dashboard</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Orders</h3>
                                    <p class="text-gray-600">View and manage orders</p>
                                </a>
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Inventory</h3>
                                    <p class="text-gray-600">Manage your inventory</p>
                                </a>
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Reports</h3>
                                    <p class="text-gray-600">View your performance</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Interface -->
                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">Chat</h2>
                            <chat-interface 
                                :order-id="null"
                                :receiver-id="null"
                            ></chat-interface>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'vendor')
                    <!-- Vendor Dashboard -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">Vendor Dashboard</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Orders</h3>
                                    <p class="text-gray-600">View and manage orders</p>
                                </a>
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Inventory</h3>
                                    <p class="text-gray-600">Manage your inventory</p>
                                </a>
                                <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                                    <h3 class="text-lg font-semibold mb-2">Reports</h3>
                                    <p class="text-gray-600">View your performance</p>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Interface -->
                    <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-4">Chat</h2>
                            <chat-interface 
                                :order-id="null"
                                :receiver-id="null"
                            ></chat-interface>
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </div>
</body>
</html>
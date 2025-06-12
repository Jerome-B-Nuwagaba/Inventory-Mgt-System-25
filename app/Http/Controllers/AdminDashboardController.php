<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Supplier;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalUsers = User::count();
        $totalSuppliers = User::where('role', 'supplier')->count();
        $totalInventory = Inventory::count();
        $totalOrders = Order::count();
        $totalReports = Report::count();

        // Get recent users
        $recentUsers = User::latest()
            ->take(5)
            ->get();

        // Get system notifications
        $notifications = Notification::latest()
            ->take(5)
            ->get();

        // Get recent orders
        $recentOrders = Order::with(['buyer', 'seller'])
            ->latest()
            ->take(5)
            ->get();

        // Get low stock inventory items
        $lowStockItems = Inventory::where('quantity', '<', 10)
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalSuppliers',
            'totalInventory',
            'totalOrders',
            'totalReports',
            'recentUsers',
            'notifications',
            'recentOrders',
            'lowStockItems'
        ));
    }
} 
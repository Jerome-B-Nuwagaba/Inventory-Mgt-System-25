<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;

class AnalystController extends Controller
{
    public function dashboard()
    {
        $totalSales = Sale::sum('amount');
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        return view('analyst.dashboard', compact('totalSales', 'totalProducts', 'totalCustomers'));
    }

    public function generateReports()
    {
        // Logic to generate reports
        return view('analyst.reports');
    }
} 
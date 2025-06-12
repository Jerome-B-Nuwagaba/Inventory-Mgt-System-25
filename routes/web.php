<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsumerController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\RetailerController;
use App\Http\Controllers\AnalystController;
use App\Http\Controllers\SupplierController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'consumer') {
        return redirect()->route('consumer.dashboard');
    }
    if (auth()->user()->role === 'supplier') {
        return view('supplier.dashboard');
    }
    if (auth()->user()->role === 'admin') {
        return app(AdminDashboardController::class)->index();
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::get('/inventory/{inventory}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('chats', ChatController::class);
    Route::post('/chats/{chat}/messages', [ChatController::class, 'storeMessage'])->name('chats.messages.store');
});

// Consumer Routes
Route::middleware(['auth', RoleMiddleware::class.':consumer'])->prefix('consumer')->name('consumer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [ConsumerController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::get('/products', [ConsumerController::class, 'products'])->name('products');
    Route::get('/products/{product}', [ConsumerController::class, 'showProduct'])->name('products.show');
    
    // Orders
    Route::get('/orders', [ConsumerController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [ConsumerController::class, 'showOrder'])->name('orders.show');
    Route::post('/products/{product}/order', [ConsumerController::class, 'createOrder'])->name('orders.create');
    Route::post('/orders/{order}/cancel', [ConsumerController::class, 'cancelOrder'])->name('orders.cancel');
    Route::get('/orders/{order}/track', [ConsumerController::class, 'trackOrder'])->name('orders.track');
    
    // Profile
    Route::get('/profile', [ConsumerController::class, 'profile'])->name('profile');
    Route::put('/profile', [ConsumerController::class, 'updateProfile'])->name('profile.update');
});

// Example for a closure in routes/web.php
Route::get('register', [RegisterController::class, 'create'])->name('register');
Route::post('register', [RegisterController::class, 'store']);

Route::get('/manufacturer/dashboard', [ManufacturerController::class, 'dashboard'])->name('manufacturer.dashboard');
Route::get('/retailer/dashboard', [RetailerController::class, 'dashboard'])->name('retailer.dashboard');
Route::get('/analyst/dashboard', [AnalystController::class, 'dashboard'])->name('analyst.dashboard');

require __DIR__.'/auth.php';


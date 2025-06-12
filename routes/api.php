<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // Product routes
    Route::apiResource('products', ProductController::class);
    Route::patch('products/{product}/production-stage', [ProductController::class, 'updateProductionStage']);

    // Order routes
    Route::apiResource('orders', OrderController::class);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus']);
    Route::get('orders/{order}/chat', [OrderController::class, 'getOrderChat']);
    Route::post('orders/{order}/chat', [OrderController::class, 'sendMessage']);

    // Warehouse routes
    Route::apiResource('warehouses', WarehouseController::class);
    Route::get('warehouses/{warehouse}/utilization', [WarehouseController::class, 'getUtilization']);
    Route::get('warehouses/{warehouse}/inventory', [WarehouseController::class, 'getInventory']);

    // Inventory routes
    Route::apiResource('inventory', InventoryController::class);
    Route::get('inventory/low-stock', [InventoryController::class, 'checkLowStock']);
    Route::get('inventory/overstocked', [InventoryController::class, 'checkOverstocked']);

    // Chat routes
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
    Route::get('/chat/order/{orderId}', [ChatController::class, 'getOrderChats']);
    Route::get('/chat/unread', [ChatController::class, 'getUnreadMessages']);
    Route::post('/chat/{chatId}/read', [ChatController::class, 'markAsRead']);
}); 
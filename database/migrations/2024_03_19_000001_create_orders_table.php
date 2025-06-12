<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->enum('item_type', ['raw_material', 'car']);
            $table->unsignedBigInteger('item_id');
            $table->integer('quantity');
            $table->enum('status', ['pending', 'approved', 'in_transit', 'delivered', 'cancelled'])->default('pending');
            $table->text('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}; 
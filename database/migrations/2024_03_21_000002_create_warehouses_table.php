<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->integer('capacity');
            $table->integer('current_utilization')->default(0);
            $table->foreignId('manager_id')->constrained('users');
            $table->string('status')->default('active');
            $table->string('contact_number');
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
}; 
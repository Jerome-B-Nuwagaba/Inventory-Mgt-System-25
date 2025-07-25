<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('production_lines', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('retailer_order_id')->nullable()->constrained()->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('production_lines', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropForeign(['retailer_order_id']);
            $table->dropColumn(['product_id', 'retailer_order_id']);
        });
    }
};
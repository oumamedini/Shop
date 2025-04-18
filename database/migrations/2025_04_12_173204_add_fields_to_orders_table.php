<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default('pending');
            $table->string('tracking_number')->nullable();
            $table->string('shipping_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'tracking_number',
                'shipping_method',
                'payment_status',
                'payment_method'
            ]);
        });
    }
};

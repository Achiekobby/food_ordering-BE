<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');
            $table->foreign('user_id')->on('users')->references('id')->cascadeOnDelete();

            $table->foreignId('menu_id');
            $table->foreign('menu_id')->on('menus')->references('id')->cascadeOnDelete();

            $table->string('amount');
            $table->enum('payment_status',['paid','not_paid']);
            $table->string('quantity');
            $table->enum('delivery_status',['pending','transit','delivered']);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('cart_id');
            $table->integer('subtotal');
            $table->integer('total');
            $table->string('promo');
            $table->enum('status',['pending','success','failed']);
            $table->integer('address_id')->nullable();
            $table->string('payment')->nullable();
            $table->enum('payment_status',['pending','success','failed']);
            $table->string('resi');
            $table->string('transfer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};

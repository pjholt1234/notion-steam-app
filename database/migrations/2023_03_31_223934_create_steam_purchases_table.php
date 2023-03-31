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
        Schema::create('steam_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('steam_item_id')->references('id')->on('steam_items')->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('purchase_cost');
            $table->date('transaction_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steam_purcahses');
    }
};

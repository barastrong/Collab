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
            Schema::create('purchases', function (Blueprint $table) {
                $table->id();
                $table->string('purchase_code')->unique();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('barang_id')->constrained('barang')->onDelete('cascade');
                $table->integer('quantity');
                $table->string('size')->nullable();
                $table->decimal('price', 10, 2);
                $table->decimal('total_price', 10, 2);
                $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
                $table->text('shipping_address');
                $table->string('phone_number');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};

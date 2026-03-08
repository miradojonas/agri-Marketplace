<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('name_mg')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('unit')->default('kg'); // kg, litre, unité
            $table->decimal('quantity_available', 10, 2);
            $table->string('image')->nullable();
            $table->enum('status', ['available', 'out_of_stock', 'pending'])->default('available');
            $table->date('harvest_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

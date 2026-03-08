<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('market_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('product_name');
            $table->string('region');
            $table->decimal('min_price', 10, 2);
            $table->decimal('max_price', 10, 2);
            $table->decimal('avg_price', 10, 2);
            $table->string('unit')->default('kg');
            $table->date('price_date');
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_prices');
    }
};

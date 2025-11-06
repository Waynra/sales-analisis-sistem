<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('platform');
            $table->date('date');
            $table->string('product_name');
            $table->integer('quantity');
            $table->decimal('price', 15, 2);
            $table->decimal('ads_cost', 15, 2)->nullable();
            $table->decimal('affiliate_fee', 15, 2)->nullable();
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

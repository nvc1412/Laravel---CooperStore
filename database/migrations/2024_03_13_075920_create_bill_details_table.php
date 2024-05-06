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
        Schema::create('bill_details', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("bill_id");
            $table->unsignedInteger("product_id");
            $table->integer('quantity');
            $table->decimal('price', 10, 0);
            $table->timestamps();
            $table->foreign("bill_id")->references("id")->on("bills");
            $table->foreign("product_id")->references("id")->on("products");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_details');
    }
};

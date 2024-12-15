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
        Schema::create('banners', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->text('link')->nullable();
            $table->string('image', 255)->nullable();
            $table->enum('position', ['Top-Banner', 'Bottom-Banner'])->default("Top-Banner");
            $table->enum('status', ['Hiện', 'Ẩn'])->default("Hiện");
            $table->integer('prioty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
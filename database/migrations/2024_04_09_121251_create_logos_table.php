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
        Schema::create('logos', function (Blueprint $table) {
            $table->increments("id");
            $table->text('link')->nullable();
            $table->string('image', 255)->nullable();
            $table->enum('position', ['Header-Logo', 'Footer-Logo', 'Web-Logo'])->default("Header-Logo");
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
        Schema::dropIfExists('logos');
    }
};
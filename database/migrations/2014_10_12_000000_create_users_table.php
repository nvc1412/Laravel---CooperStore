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
        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string('name', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('phone', 15)->nullable();
            $table->string('address', 255)->nullable();
            $table->tinyInteger('is_admin')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
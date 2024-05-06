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
        Schema::create('bill_verify_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->unsignedInteger("bill_id");
            $table->string('token');
            $table->timestamps();
            $table->foreign("bill_id")->references("id")->on("bills");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_verify_tokens');
    }
};

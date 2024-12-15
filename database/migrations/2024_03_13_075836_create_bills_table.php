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
        Schema::create('bills', function (Blueprint $table) {
            $table->increments("id");
            $table->unsignedInteger("user_id");
            $table->string("name", 100);
            $table->string('email', 100);
            $table->string('phone', 15);
            $table->string('address', 255);
            $table->text("note")->nullable();
            $table->string('payment', 255);
            $table->enum('status', ['Chờ thanh toán', 'Chờ xử lý', 'Đang vận chuyển', 'Thành công', 'Thất bại', 'Hủy'])->default("Chờ thanh toán");
            $table->decimal('total', 10, 0);
            $table->timestamps();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
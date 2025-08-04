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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // Tên khách hàng
            $table->date('birthday')->nullable();    // Ngày sinh
            $table->string('phone')->nullable();     // SĐT
            $table->string('occupation')->nullable();// Nghề nghiệp
            $table->string('facebook')->nullable();  // Facebook
            $table->string('rank')->nullable();      // Hạng
            $table->string('gender')->nullable();    // Giới tính
            $table->string('city')->nullable();      // Tỉnh/Tp
            $table->string('district')->nullable();  // Quận/Huyện
            $table->string('ward')->nullable();      // Phường/Xã
            $table->string('address')->nullable();   // Địa chỉ chi tiết
            $table->string('source')->nullable();    // Nguồn khách hàng
            $table->string('referrer')->nullable();  // Người giới thiệu
            $table->string('branch')->nullable();    // Chi nhánh
            $table->text('note')->nullable();        // Ghi chú
            $table->string('photo_path')->nullable();// Ảnh khách hàng
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

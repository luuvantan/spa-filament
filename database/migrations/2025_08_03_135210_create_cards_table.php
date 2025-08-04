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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên thẻ: e.g., "Thẻ kiểm dầu cấp nước Obagi"
            $table->foreignId('customer_id')->nullable(); // Liên kết với bảng khách hàng
            $table->string('type'); // Loại thẻ: e.g., "Thẻ liệu trình", "Thẻ combo"
            $table->integer('sessions')->nullable(); // Số buổi liệu trình
            $table->unsignedInteger('hours')->default(0);
            $table->unsignedInteger('minutes')->default(0);
            $table->date('issue_date'); // Ngày cấp
            $table->date('start_date'); // Ngày bắt đầu
            $table->date('end_date'); // Ngày kết thúc
            $table->string('status')->default('sudung'); // Trạng thái: e.g., "Sử dụng", "Hết hạn", "Hoàn thành"
            $table->text('notes')->nullable(); // Ghi chú
            $table->decimal('price', 15, 2)->default(0); // Giá thẻ
            $table->decimal('commission_per_session', 15, 2)->nullable(); // Hoa hồng
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};

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
        Schema::table('customer_cards', function (Blueprint $table) {
            //
            $table->dropForeign(['card_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['branch_id']);
            $table->integer('card_id')->change();
            $table->integer('customer_id')->change();
            $table->integer('branch_id')->change();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_cards', function (Blueprint $table) {
            //
        });
    }
};

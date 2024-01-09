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
        Schema::table('deposite_transactions', function (Blueprint $table) {
            $table->string("for", 255)->nullable();
        });
        Schema::table('withdraw_histories', function (Blueprint $table) {
            $table->string("for", 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('add_for_transaction', function (Blueprint $table) {
            //
        });
    }
};

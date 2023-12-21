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
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('coin_type',20)->unique();
            $table->tinyInteger('currency_type')->default(1);
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('coin_price',19, 8)->default(1);
            $table->tinyInteger('network')->default(1);

            $table->tinyInteger('is_withdrawal')->default(1);
            $table->decimal('minimum_withdrawal', 19, 8)->default(0.0000001);
            $table->decimal('maximum_withdrawal', 19, 8)->default(99999999.0);
            $table->decimal('max_send_limit', 19, 8)->default(0.0000001);
            $table->decimal('withdrawal_fees', 29, 18)->default(0.0000001);
            $table->tinyInteger('withdrawal_fees_type')->default(2);
            
            $table->tinyInteger('is_deposit')->default(1);
            $table->string('coin_icon')->nullable();
            
            $table->tinyInteger('is_convert')->default(1);
            $table->decimal('minimum_convert', 19, 8)->default(0.0000001);
            $table->decimal('maximum_convert', 19, 8)->default(99999999.0);
            $table->decimal('convert_fees', 29, 18)->default(0.0000001);
            $table->tinyInteger('convert_fees_type')->default(2);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coins');
    }
};

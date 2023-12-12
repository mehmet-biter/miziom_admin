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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('coin_type',20)->unique();
            $table->tinyInteger('currency_type')->default(1);
            $table->unsignedInteger('currency_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('network')->default(1);
            $table->tinyInteger('is_withdrawal')->default(1);
            $table->tinyInteger('is_deposit')->default(1);
            $table->string('coin_icon', 50)->nullable();
            $table->boolean('is_wallet')->default(0);
            $table->boolean('is_transferable')->default(0);
            $table->boolean('is_virtual_amount')->default(0);
            $table->string('sign')->nullable()->collation('utf8_unicode_ci');
            $table->decimal('minimum_buy_amount', 19.0, 8.0)->default(0.0000001);
            $table->decimal('maximum_buy_amount', 19.0, 8.0)->default(999999);
            $table->decimal('minimum_sell_amount', 19.0, 8.0)->default(0.0000001);
            $table->decimal('maximum_sell_amount', 19.0, 8.0)->default(999999);
            $table->decimal('minimum_withdrawal', 19, 8)->default(0.0000001);
            $table->decimal('maximum_withdrawal', 19, 8)->default(99999999.0);
            $table->decimal('max_send_limit', 19, 8)->default(0.0000001);
            $table->decimal('withdrawal_fees', 29, 18)->default(0.0000001);
            $table->tinyInteger('withdrawal_fees_type')->default(2);
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

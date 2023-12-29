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
        Schema::create('withdraw_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->decimal('amount',19,8)->default(0);
            $table->decimal('btc',19,8)->default(0);
            $table->decimal('doller',19,8)->default(0);
            $table->tinyInteger('address_type');
            $table->string('address');
            $table->string('transaction_hash');
            $table->string('coin_type')->default('BTC');
            $table->decimal('used_gas',19,8)->default(0);
            $table->string('receiver_wallet_id')->nullable();
            $table->string('confirmations')->nullable();
            $table->decimal('fees',29,18)->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('updated_by')->nullable();
            $table->string('automatic_withdrawal')->nullable();
            $table->string('network_type')->nullable();
            $table->string('memo')->nullable();
            $table->longText('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraw_histories');
    }
};

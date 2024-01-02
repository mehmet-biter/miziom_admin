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
        Schema::create('deposite_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address');
            $table->string('from_address')->nullable();
            $table->decimal('fees',29,18)->default(0);
            $table->bigInteger('sender_wallet_id')->nullable();
            $table->bigInteger('receiver_wallet_id')->unsigned();
            $table->string('address_type');
            $table->string('coin_type')->nullable();
            $table->decimal('amount',29,18)->default(0);
            $table->decimal('btc',19,8)->default(0);
            $table->decimal('doller',19,8)->default(0);
            $table->string('transaction_id');
            $table->tinyInteger('is_admin_receive')->default(0);
            $table->decimal('received_amount',29,18)->default(0);
            $table->tinyInteger('status')->default(0);
            $table->bigInteger('updated_by')->nullable();
            $table->string('network_type')->nullable();
            $table->integer('confirmations')->default(0);
            $table->tinyInteger('transaction_type')->default(TRANSACTION_TYPE_DEPOSIT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposite_transactions');
    }
};

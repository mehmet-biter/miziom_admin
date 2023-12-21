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
        Schema::create('coin_settings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('coin_id');
            $table->string('bitgo_wallet_id')->nullable();
            $table->tinyInteger('bitgo_deleted_status')->default(false);
            $table->tinyInteger('bitgo_approvalsRequired')->default(0);
            $table->string('bitgo_wallet_type')->nullable();
            $table->text('bitgo_wallet')->nullable();
            $table->integer('chain')->default(1);
            $table->tinyInteger('webhook_status')->default(0);
            $table->string('coin_api_user')->nullable();
            $table->text('coin_api_pass')->nullable();
            $table->string('coin_api_host')->nullable();
            $table->string('coin_api_port')->nullable();
            $table->tinyInteger('check_encrypt')->default(0);
            $table->string('bitgo_webhook_label',180)->nullable();
            $table->string('bitgo_webhook_type',50)->nullable();
            $table->string('bitgo_webhook_url',180)->nullable();
            $table->string('bitgo_webhook_numConfirmations',50)->nullable();
            $table->string('bitgo_webhook_allToken',50)->nullable();
            $table->string('bitgo_webhook_id',180)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_settings');
    }
};

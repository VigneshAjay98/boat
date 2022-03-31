<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique()->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->datetime('order_date')->nullable();
            $table->enum('status', ['pending', 'paid','cancelled', 'failed'])->default('pending');
            $table->enum('payment_type', ['stripe']);
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->string('stripe_customer_id', 250)->nullable();
            $table->string('stripe_payment_id', 250)->nullable();
            $table->float('order_total', 10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_transactions');
    }
}

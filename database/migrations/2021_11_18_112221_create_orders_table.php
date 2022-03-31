<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('boat_id');
            $table->datetime('order_date')->nullable();
            $table->enum('status', ['pending', 'paid','cancelled', 'failed'])->default('pending');
            $table->enum('payment_type', ['stripe']);
            $table->string('stripe_customer_id', 250)->nullable();
            $table->string('stripe_payment_id', 250)->nullable();
            $table->float('order_total', 10,2);
            $table->boolean('auto_renewal')->default(0);
            $table->unsignedBigInteger('auto_renewal_discount');
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
        Schema::dropIfExists('orders');
    }
}



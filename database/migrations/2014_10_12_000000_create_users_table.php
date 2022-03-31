<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->string('contact_number', 25)->nullable();
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('city', 80)->nullable();
            $table->string('country', 80)->nullable();
            $table->string('state', 80)->nullable();
            $table->string('zip_code', 45)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['admin', 'user']);
            $table->boolean('is_request_price')->default(1);
            $table->string('stripe_customer_id', 250)->nullable();
            $table->string('stripe_payment_token', 250)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}


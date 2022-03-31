<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boats', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->enum('boat_type', ['Power', 'Sail', 'Personal Watercraft'])->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('hull_material', 50)->nullable();
            $table->float('length', 10,2)->nullable();
            $table->string('model', 200)->nullable();
            $table->string('boat_name', 250)->nullable();
            $table->year('year')->nullable();
            $table->string('slug', 250)->unique()->nullable();
            $table->double('price')->nullable();
            $table->string('price_currency', 4)->default('USD');
            $table->longtext('general_description')->nullable();
            $table->boolean('is_request_price')->default(0);
            $table->enum('boat_condition', ['New', 'Used', 'Salvage Title'])->nullable();
            $table->string('country', 250)->nullable();
            $table->string('state', 250)->nullable();
            $table->string('zip_code', 250)->nullable();
            $table->enum('is_active', ['Y', 'N'])->default('Y');
            $table->enum('publish_status', ['draft', 'published'])->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
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
        Schema::dropIfExists('boats');
    }
}

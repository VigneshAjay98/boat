<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoatImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boat_images', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique()->nullable();
            $table->unsignedBigInteger('boat_id');
            $table->string('image_name', 255)->nullable();
            $table->string('image_type', 255)->nullable();
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
        Schema::dropIfExists('boat_images');
    }
}

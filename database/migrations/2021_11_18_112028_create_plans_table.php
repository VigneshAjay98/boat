<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique()->nullable();
            $table->string('name', 100);
            $table->float('price', 10, 2);
            $table->unsignedBigInteger('duration_weeks')->nullable();
            $table->unsignedBigInteger('image_number')->nullable();
            // $table->tinyInteger('videos_allowed')->nullable();
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
        Schema::dropIfExists('plans');
    }
}

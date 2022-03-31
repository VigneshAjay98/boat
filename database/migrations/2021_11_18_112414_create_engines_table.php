<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique()->nullable();
            $table->unsignedBigInteger('boat_id');
            $table->enum('engine_type', ['electric', 'inboard', 'outboard', 'other'])->nullable();
            $table->enum('fuel_type', ['diesel', 'electric', 'gasoline', 'lpg', 'other'])->nullable();
            $table->string('make', 150)->nullable();
            $table->string('model', 150)->nullable();
            $table->double('horse_power')->nullable();
            $table->unsignedBigInteger('engine_hours')->nullable();
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
        Schema::dropIfExists('engines');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_information', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique()->nullable();
            $table->unsignedBigInteger('boat_id')->nullable();
            $table->string('12_digit_HIN', 45)->nullable();
            $table->string('anchor_type', 250)->nullable();
            $table->double('draft')->nullable();
            $table->double('bridge_clearance')->nullable();
            $table->string('designer', 150)->nullable();
            $table->enum('electrical_system', ['12 VDC', '110 VAC', '220 VAC'])->nullable();
            $table->enum('generator_fuel_type', ['gas', 'diesel', 'inverter'])->nullable();
            $table->double('generator_size')->nullable();
            $table->double('generator_hours')->nullable();
            $table->unsignedBigInteger('cabin_berths')->nullable();
            $table->longtext('cabin_description', 45)->nullable();
            $table->longtext('galley_description', 45)->nullable();
            $table->unsignedBigInteger('fuel_capacity')->nullable();
            $table->unsignedBigInteger('holding')->nullable();
            $table->unsignedBigInteger('fresh_water')->nullable();
            $table->unsignedBigInteger('cruising_speed')->nullable();
            $table->double('LOA')->nullable();
            // $table->integer('tank')->default(1);
            $table->unsignedBigInteger('max_speed')->nullable();
            $table->double('beam_feet')->nullable();
            $table->longtext('mechanical_equipment', 45)->nullable();
            $table->longtext('deck_hull_equipment', 45)->nullable();
            $table->longtext('navigation_systems', 45)->nullable();
            $table->longtext('additional_equipment', 45)->nullable();
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
        Schema::dropIfExists('other_information');
    }
}

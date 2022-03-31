<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('countries', function (Blueprint $table) {
            $table->char('code', 3)->default('')->primary()->index();
            $table->string('s_order', 255)->nullable();
            $table->string('region', 255)->nullable();
            $table->char('selector', 3)->nullable();
            $table->string('ship_modes', 255)->nullable();
            $table->string('name', 32)->default('')->index();
            $table->char('iso', 3)->default('');
            $table->char('iso_number', 3)->default('');
            $table->string('tax', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}

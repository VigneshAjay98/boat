<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table) {
            $table->string('country', 20)->default('');
            $table->string('state', 20)->default('');
            $table->string('name', 64)->default('');
            $table->enum('timezone', ['EASTERN','CENTRAL','PACIFIC','MOUNTAIN','UNKNOWN'])->default('UNKNOWN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
}

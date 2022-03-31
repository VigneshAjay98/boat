<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPlanAddon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_plan_addons', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('boat_id')->nullable();
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('addon_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_plan_addons');
    }
}

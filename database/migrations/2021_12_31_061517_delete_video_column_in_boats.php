<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteVideoColumnInBoats extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boats', function (Blueprint $table) {
            Schema::table('boats', function (Blueprint $table) {
                $table->dropColumn('video');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boats', function (Blueprint $table) {
            //
        });
    }
}

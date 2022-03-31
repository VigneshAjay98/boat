<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateElectricalSystemInOtherInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_information', function (Blueprint $table) {
            if (Schema::hasColumn('other_information', 'electrical_system')) {
                $table->string('electrical_system', 255)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('other_information', function (Blueprint $table) {
            if (Schema::hasColumn('other_information', 'electrical_system')) {
                $table->dropColumn('electrical_system');
            }
        });
    }
}

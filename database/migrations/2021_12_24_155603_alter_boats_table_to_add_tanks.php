<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBoatsTableToAddTanks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_information', function (Blueprint $table) {
            if (!Schema::hasColumn('other_information', 'tanks')) {
                $table->integer('tanks')->default(1)->after('LOA');
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
            if (Schema::hasColumn('other_information', 'tanks')) {
                $table->dropColumn('tanks');

            }
        });
    }
}

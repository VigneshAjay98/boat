<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeadColumnToOtherInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('other_information', function (Blueprint $table) {
            if (!Schema::hasColumn('other_information', 'head')) {
                $table->unsignedBigInteger('head')->nullable()->after('designer');
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
            if (Schema::hasColumn('other_information', 'head')) {
                $table->dropColumn('head');
            }
        });
    }
}

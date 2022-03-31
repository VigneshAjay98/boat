<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveAndUpdateVideoColumnInPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasColumn('plans', 'is_video_allowed')) {
            Schema::table('plans', function (Blueprint $table) {
                $table->dropColumn('is_video_allowed');
            });
        }
        Schema::table('plans', function (Blueprint $table) {
            if (!Schema::hasColumn('plans', 'video_number')) {
                $table->unsignedBigInteger('video_number')->nullable()->after('image_number');
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
        Schema::table('plans', function (Blueprint $table) {
            if (Schema::hasColumn('plans', 'video_number')) {
                $table->dropColumn('video_number');
            }
        });
    }
}

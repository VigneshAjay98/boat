<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionIdAndVideoToBoatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boats', function (Blueprint $table) {
            if (!Schema::hasColumn('boats', 'subscription_id')) {
                $table->unsignedBigInteger('subscription_id')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('boats', 'video')) {
                $table->string('video')->nullable()->after('boat_condition');
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
        Schema::table('boats', function (Blueprint $table) {
            if (Schema::hasColumn('boats', 'subscription_id')) {
                $table->dropColumn('subscription_id');
            }
            if (Schema::hasColumn('boats', 'video')) {
                $table->dropColumn('video');
            }
        });
    }
}

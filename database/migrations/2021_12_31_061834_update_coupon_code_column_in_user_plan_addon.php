<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCouponCodeColumnInUserPlanAddon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_plan_addons', function (Blueprint $table) {
            if(Schema::hasColumn('user_plan_addons', 'coupon_code')) {
                Schema::table('user_plan_addons', function (Blueprint $table) {
                    $table->dropColumn('coupon_code');
                });
            }
            if (!Schema::hasColumn('user_plan_addons', 'coupon_id')) {
                $table->unsignedBigInteger('coupon_id')->nullable()->after('addon_id');
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
        Schema::table('user_plan_addons', function (Blueprint $table) {
            if (Schema::hasColumn('user_plan_addons', 'coupon_code')) {
                $table->dropColumn('coupon_code');
            }
        });
    }
}

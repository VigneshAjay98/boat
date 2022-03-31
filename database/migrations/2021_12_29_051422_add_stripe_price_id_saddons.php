<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStripePriceIdSaddons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_addons', function (Blueprint $table) {
            if (!Schema::hasColumn('plan_addons', 'stripe_price_id')) {
                $table->string('stripe_price_id')->nullable()->after('addon_cost');
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
        Schema::table('plan_addons', function (Blueprint $table) {
            if (Schema::hasColumn('plan_addons', 'stripe_price_id')) {
                $table->dropColumn('stripe_price_id');

            }
        });
    }
}

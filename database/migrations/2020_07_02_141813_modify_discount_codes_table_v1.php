<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDiscountCodesTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropColumn('redemmed_on');
            $table->integer('redeem_count')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('discount_codes', function (Blueprint $table) {
            $table->dropColumn('redeem_count');
        });
    }
}

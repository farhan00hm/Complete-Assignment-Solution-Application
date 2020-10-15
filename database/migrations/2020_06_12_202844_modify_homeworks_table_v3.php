<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyHomeworksTableV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->bigInteger('winning_bid_id')->unsigned()->nullable()->after('sub_category_id');
            $table->foreign('winning_bid_id')->references('id')->on('bids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->dropColumn('winning_bid_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySubjectsTableV3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subjects', function (Blueprint $table) {
            $table->bigInteger('sub_category_id')->after('expert_id')->nullable()->unsigned();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('sub_category_id');
        });
    }
}

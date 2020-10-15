<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFlaggedHomeworksV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('flagged_homeworks', function (Blueprint $table) {
            $table->date('resolution_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('flagged_homeworks', function (Blueprint $table) {
            $table->dropColumn('resolution_date');
        });
    }
}

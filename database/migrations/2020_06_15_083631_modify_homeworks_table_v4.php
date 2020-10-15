<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyHomeworksTableV4 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('homeworks', function (Blueprint $table) {
            $table->date('hired_on')->nullable()->after('deadline');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::table('homeworks', function (Blueprint $table) {
            $table->dropColumn('hired_on');
        });
    }
}

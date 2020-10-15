<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBidsTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('bids', function (Blueprint $table) {
            $table->longText('proposal')->nullable()->after('status');
            $table->date('expected_completion_date')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('bids', function (Blueprint $table) {
            $table->dropColumn('proposal');
            $table->dropColumn('expected_completion_date');
        });
    }
}

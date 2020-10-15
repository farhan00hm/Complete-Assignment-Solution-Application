<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyExpertsTableV2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('experts', function (Blueprint $table) {
            $table->string('certificate_path')->nullable()->after('resume_path');
            $table->string('account_number')->nullable()->after('description');
            $table->string('bank_name')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('experts', function (Blueprint $table) {
            $table->dropColumn('certificate_path');
        });
    }
}

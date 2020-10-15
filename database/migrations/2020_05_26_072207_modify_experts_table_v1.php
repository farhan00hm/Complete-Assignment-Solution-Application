<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModifyExpertsTableV1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('subjects', function (Blueprint $table) {
           $table->dropForeign('tutor_subjects_tutor_id_foreign');

            $table->dropColumn(['tutor_id']);

            $table->bigInteger('expert_id')->unsigned()->after('id');
            $table->foreign('expert_id')
                ->references('id')
                ->on('experts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

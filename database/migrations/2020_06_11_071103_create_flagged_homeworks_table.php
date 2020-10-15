<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlaggedHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('flagged_homeworks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->bigInteger('flagged_by')->unsigned();
            $table->foreign('flagged_by')->references('id')->on('users');
            $table->smallInteger('resolution_status')->default(1)->comment('1 - reported, 2 - admin confirmed flag, 3 - admin reversed flag');
            $table->longText('reason');
            $table->date('resolution_date');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE flagged_homeworks AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flagged_homeworks');
    }
}

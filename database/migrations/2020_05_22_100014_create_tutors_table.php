<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tutors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->smallInteger('approved')->default(0)->comment("0 - pending, 1 - approved, 3 - suspended");
            $table->string('qualification');
            $table->text('description');
            $table->string('original_file_name');
            $table->string('resume_path');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE tutors AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutors');
    }
}

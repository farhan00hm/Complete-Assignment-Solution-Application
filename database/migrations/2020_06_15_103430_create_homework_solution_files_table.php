<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkSolutionFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('homework_solution_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homework_solution_id')->unsigned();
            $table->foreign('homework_solution_id')->references('id')->on('homework_solutions');
            $table->string('name')->nullable();
            $table->string('original_file_name');
            $table->string('upload_path');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homework_solution_files');
    }
}

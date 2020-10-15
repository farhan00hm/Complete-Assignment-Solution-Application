<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpertFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('expert_files', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('expert_id')->unsigned();
            $table->foreign('expert_id')->references('id')->on('experts');
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
        Schema::dropIfExists('expert_files');
    }
}

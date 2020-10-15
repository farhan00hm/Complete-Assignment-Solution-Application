<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworkSolutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('homework_solutions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->longText('notes')->nullable();
            $table->smallInteger('status')->default(1)->comment('1 - submitted, 2 - accepted, 3 - declined, 4 - admin accepted, 5 - admin declined');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE homework_solutions AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homework_solutions');
    }
}

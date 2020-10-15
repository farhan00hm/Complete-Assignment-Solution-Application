<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('homeworks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('posted_by')->unsigned();
            $table->foreign('posted_by')->references('id')->on('users');
            $table->bigInteger('awarded_to')->unsigned()->nullable();
            $table->foreign('awarded_to')->references('id')->on('users');
            $table->bigInteger('sub_category_id')->unsigned()->nullable();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories');
            $table->string('title');
            $table->smallInteger('status')->default(1)->comment('1 - Posted, 2 - Archived etc');
            $table->longText('description');
            $table->date('deadline');
            $table->decimal('budget', 13, 2);
            $table->decimal('winning_bid_amount', 13, 2)->nullable();
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE homeworks AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('homeworks');
    }
}

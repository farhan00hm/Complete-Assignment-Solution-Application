<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('weekly_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->comment('The Admin/subadmin');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_to_email');
            $table->integer('transaction_count');
            $table->decimal('transaction_total', 13, 2);
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
        Schema::dropIfExists('weekly_payments');
    }
}

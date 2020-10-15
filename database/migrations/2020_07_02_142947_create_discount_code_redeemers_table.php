<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodeRedeemersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('discount_code_redeemers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('discount_code_id')->unsigned();
            $table->foreign('discount_code_id')->references('id')->on('discount_codes');
            $table->bigInteger('user_id')->unsigned()->comment('The student');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE discount_code_redeemers AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_code_redeemers');
    }
}

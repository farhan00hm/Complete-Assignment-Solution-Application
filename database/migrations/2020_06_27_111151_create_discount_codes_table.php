<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by')->unsigned()->comment('The admin/subadmin creator');
            $table->foreign('created_by')->references('id')->on('users');
            $table->bigInteger('discounted_by')->unsigned()->nullable()->comment('The admin/subadmin issuing the code to a student/FL');
            $table->foreign('discounted_by')->references('id')->on('users');
            $table->bigInteger('discounted_to')->unsigned()->nullable()->comment('The Student/Professional/Se receiving the code');
            $table->foreign('discounted_to')->references('id')->on('users');
            $table->string('code');
            $table->decimal('amount', 13, 2)->default(0.00);
            $table->string('status')->default('CREATED')->comment('CREATED, REDEEMED, INVALIDATED');
            $table->date('discounted_on')->nullable();
            $table->date('redemmed_on')->nullable();
            $table->date('invalidated_on')->nullable();
            $table->text('comments')->nullable()->comment('To be input by Admin/Sub when issuing');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE discount_codes AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}

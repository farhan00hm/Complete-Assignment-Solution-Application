<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->bigInteger('user_id')->unsigned()->comment('The Bidder - user type FL on users table');
            $table->foreign('user_id')->references('id')->on('users');
            $table->decimal('amount', 13, 2);
            $table->smallInteger('status')->default(0)->comment('0 - submitted, 1 - accepted, 3 - declined');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE bids AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bids');
    }
}

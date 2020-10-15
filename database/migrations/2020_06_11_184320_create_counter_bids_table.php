<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCounterBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('counter_bids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bid_id')->unsigned();
            $table->foreign('bid_id')->references('id')->on('bids');
            $table->decimal('amount', 13, 2);
            $table->smallInteger('status')->default(0)->comment('0 - submitted, 1 - accepted, 3 - declined');
            $table->text('note');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE counter_bids AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_bids');
    }
}

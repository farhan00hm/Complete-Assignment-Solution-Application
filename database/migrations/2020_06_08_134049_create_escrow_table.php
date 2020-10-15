<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEscrowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escrow', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->bigInteger('bid_id')->unsigned();
            $table->foreign('bid_id')->references('id')->on('bids');
            $table->bigInteger('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->decimal('amount', 13, 2);
            $table->string('status')->default('ACTIVE')->comment('ACTIVE, MATURED');
            $table->smallInteger('disputed')->default(0)->comment('1 - disputed, 0 - not disputed');
            $table->text('comments')->nullable();
            $table->date('maturity_date')->nullable();
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE escrow AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('escrow');
    }
}

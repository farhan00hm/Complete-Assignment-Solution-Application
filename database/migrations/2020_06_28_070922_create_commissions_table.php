<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->bigInteger('escrow_id')->unsigned();
            $table->foreign('escrow_id')->references('id')->on('escrow');
            $table->decimal('amount', 13, 2);
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE commissions AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}

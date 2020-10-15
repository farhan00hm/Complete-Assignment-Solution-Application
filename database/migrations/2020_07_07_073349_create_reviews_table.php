<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reviewer')->unsigned()->comment('The one doing the review');
            $table->foreign('reviewer')->references('id')->on('users');
            $table->bigInteger('reviewee')->unsigned()->comment('The one receiving the review');
            $table->foreign('reviewee')->references('id')->on('users');
            $table->bigInteger('homework_id')->unsigned();
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->decimal('rating', 5, 2)->default(1.0);
            $table->longText('review');
            $table->string('uuid');
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE reviews AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_user')->unsigned()->nullable()->comment('The user ID whose wallet will be debited');
            $table->foreign('from_user')->references('id')->on('users');
            $table->bigInteger('to_user')->unsigned()->nullable()->comment('The user ID whose wallet will be credited');
            $table->foreign('to_user')->references('id')->on('users');
            $table->bigInteger('initiator')->unsigned()->comment('Mostly admin/subadmin for scheduled withdrawal');
            $table->foreign('initiator')->references('id')->on('users');
            $table->bigInteger('homework_id')->unsigned()->nullable()->comment('Only when paying for homework');
            $table->foreign('homework_id')->references('id')->on('homeworks');
            $table->string('sk_ref');
            $table->decimal('amount', 13, 2);
            $table->string('status')->default(0)->comment('1 - CREATED, 2 - COMPLETED , 3 - DECLINED');
            $table->string('type')->comment('TOPUP, PAY, ADMIN WITHDRAW');
            $table->string('processor')->comment('E.g Paystack, Stripe etc');
            $table->string('processor_id')->nullable();
            $table->string('processor_status')->nullable();
            $table->string('provider_payer_name')->nullable();
            $table->string('provider_payer_email')->nullable();
            $table->text('comments')->nullable();
            $table->string('uuid');
            $table->timestamp('provider_transaction_datetime')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE transactions AUTO_INCREMENT = 1001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('entity');
            $table->bigInteger('amount');
            $table->string('currency');
            $table->string('status'); //-created-authorized-captured-refunded-failed
            $table->string('order_id');
            $table->string('invoice_id')->nullable();
            $table->boolean('international');
            $table->string('method'); //-card-netbanking-wallet- emi-upi
            $table->bigInteger('amount_refunded')->nullable();
            $table->string('refund_status')->nullable(); //- null- partial- full.
            $table->boolean('captured');
            $table->string('description');
            $table->string('card_id')->nullable();
            $table->string('bank')->nullable();
            $table->string('wallet')->nullable();
            $table->string('vpa')->nullable();
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->longText('notes')->nullable();
            $table->string('fee')->nullable();
            $table->string('tax')->nullable();
            $table->string('error_code')->nullable();
            $table->string('error_description')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}

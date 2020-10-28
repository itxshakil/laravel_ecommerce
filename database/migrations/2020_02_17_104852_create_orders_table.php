<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->foreignId('user_id')->constrained();
            $table->string('entity');
            $table->bigInteger('amount');
            $table->bigInteger('amount_paid')->nullable();
            $table->bigInteger('amount_due')->nullable();
            $table->string('currency');
            $table->string('receipt');
            $table->string('offer_id')->nullable();
            $table->string('status');
            $table->integer('attempts');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

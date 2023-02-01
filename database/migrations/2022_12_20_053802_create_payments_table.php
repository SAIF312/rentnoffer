<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->foreign('customer')->references('stripe_id')->on('users')->cascadeOnDelete();
            $table->string('payment_method_id');
            $table->foreign('payment_method_id')->references('payment_method')->on('payment_methods')->cascadeOnDelete();
            $table->string('payment_intent');
            $table->foreign('payment_intent')->references('payment_id')->on('orders')->cascadeOnDelete();
            $table->double('amount');
            $table->string('currency');
            $table->string('status');
            $table->timestamp('created');
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
        Schema::dropIfExists('payments');
    }
};

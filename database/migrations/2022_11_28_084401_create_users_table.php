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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('status_id')->default(1)->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnDelete();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->string('username')->unique();
            $table->string('full_name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('bio')->default(null)->nullable();
            $table->string('cover_img')->nullable();
            $table->string('profile_img')->nullable();
            $table->float('balance')->default(0.0)->unsigned();
            $table->integer('otp')->nullable();
            $table->integer('mismatch_limit')->default(0);
            $table->boolean('email_verification')->default(0);
            $table->boolean('phone_verification')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->double('lender_revenue')->default(0);
            $table->double('borrower_revenue')->default(0);
            $table->string('password');
            $table->boolean('is_lender')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

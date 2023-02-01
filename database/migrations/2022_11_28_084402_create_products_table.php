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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnDelete();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete();
            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('rule_for_use')->nullable();
            $table->string('privacy_notes')->nullable();
            $table->double('lat')->nullable();
            $table->double('lng')->nullable();
            $table->float('price1')->nullable();
            $table->float('price7')->nullable();
            $table->float('price30')->nullable();
            $table->integer('minimum_rent_days');
            $table->float('value');
            $table->integer('views')->default(0);
            $table->integer('sales')->default(0);
            $table->string('feature_image')->nullable();
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
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses')->cascadeOnDelete();
            $table->bigInteger('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete();
            $table->boolean('is_popular')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('featured_image');
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
        Schema::dropIfExists('categories');
    }
};

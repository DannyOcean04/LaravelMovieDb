<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userid')->unsigned();
            $table->bigInteger('movieid')->unsigned();
            $table->enum('rating',['0', '1', '2','3','4','5'])->default('0');
            $table->string('comments', 256)->nullable();
            $table->timestamps();
            $table->foreign('userid')->references('id')->on('users');
            $table->foreign('movieid')->references('id')->on('movies');
        });
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

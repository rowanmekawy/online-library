<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBookCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_book_cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('cart_id')->unsigned();
            $table->integer('book_id')->unsigned();
            $table->integer('promo_id')->unsigned();
            // $table->integer('quantity');
            $table->integer('price');
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('cart_id')->references('id')->on('carts');
            // $table->foreign('book_id')->references('id')->on('books');
            //$table->foreign('promo_id')->references('id')->on('promocodes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user-book-carts');
    }
}

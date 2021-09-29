<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBookWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_book_wishlists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('wishlist_id')->unsigned();
            $table->integer('book_id')->unsigned();
            $table->integer('price');
            $table->timestamps();
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('wishlist_id')->references('id')->on('wishlists');
            // $table->foreign('book_id')->references('id')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user-book-wishlists');
    }
}

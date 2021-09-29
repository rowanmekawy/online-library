<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\bookController;
use App\Http\Controllers\ProductController;
use App\Models\book;
use App\Models\cart;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Route::get('/logout', function () {
//     if (session()->has('user'))
//     {
//         session()->pull('user');
//     }
//     return view('login');
// });

Route::get('home', function () {
    return view('index');
});

// Route::get('wishlist', function () {
//     return view('wishlist');
// });
Route::get('contact-us', function () {
    return view('contact-us');
});
Route::get('about-us', function () {
    return view('about-us');
});
Route::get('error-404', function () {
    return view('error-404');
});
Route::get('frequently-questions', function () {
    return view('frequently-questions');
});

// Route::get('admin-booklist', function () {
//     return view('admin-booklist');
// });
// Route::get('admin-dashboard', function () {
//     return view('admin-dashboard');
// });
Route::get('shop-right-sidebar', function () {
    return view('shop-right-sidebar', ['books' => book::all()]);
});
// Route::get('checkout', function () {
//     return view('checkout');
// });

Route::get('register', [PostController::class, 'register'])->name('register');
Route::post('register', [PostController::class, 'customRegistration']); 
// Route::post('shop-right-sidebar', [PostController::class, 'customRegistration']); 
// Route::get('my-account', [PostController::class, 'customRegistration']); 
Route::get('login', [PostController::class, 'login'])->name('login');
Route::post('login', [PostController::class, 'customLogin'])->name('login');
Route::post('my-account', [PostController::class, 'customLogin'])->name('my-account'); 

Route::middleware(['auth'])->group(function(){
    Route::get('my-account', function () {
        return view('my-account');
    });
    
    Route::post('my-account', [PostController::class, 'customUpdate'])->name('my-account');
    Route::post('add-to-cart', [ProductController::class, 'addToCart']);
    Route::post('add-to-wishlist/', [ProductController::class, 'addToWishlist']);
    Route::get('destroy_wishlist/{book_id}', [ProductController::class, 'destroy_wishlist']);
    Route::get('destroy_cartList/{book_id}', [ProductController::class, 'destroy_cartList']);
    Route::get('cart', [ProductController::class, 'cartList'])->name('cartList');
    Route::get('wishlist', [ProductController::class, 'wishlist'])->name('wishlist');
});

Route::get('/logout', function () {
    // Session :: forget ('user');
    return redirect('login')->with(Auth::logout());
});
// route :: prefix ('admin')->name('admin.')->group(function(){
    route:: middleware(['guest:admin'])->group(function(){
        Route::post('admin-login', [adminController::class, 'adminLogin'])->name('admin-login');
    });
    Route::middleware(['auth:admin'])->group(function(){
        Route::get('admin-dashboard', [bookController::class, 'dashboard'])->name('admin-dashboard');
        Route::post('admin-dashboard', [bookController::class, 'dashboard'])->name('admin-dashboard');
        Route::post('admin-booklist', [bookController::class, 'addBook'])->name('admin-booklist'); 
        Route::get('admin-booklist', [bookController::class, 'booklist'])->name('admin-booklist');
        Route::get('admin-editbook/{id}', [bookController::class, 'edit']);
        Route::post('admin-editbook/admin-editbook', [bookController::class, 'editbook']);
        Route::get('destroy/{id}', [bookController::class, 'destroy']);

    });
// });
Route::get('admin-login', [adminController::class, 'loginview'])->name('admin-login');


Route::resource('books',bookController::class);


Route::get('product-details/{id}', [ProductController::class, 'details']);
Route::get('search', [ProductController::class, 'search']);
Route::get('newBooks', [ProductController::class, 'newBooks']);



// Route::delete('remove-from-cart', 'ProductController@remove');
// // Route::delete('remove-from-cart', [ProductController::class, 'remove']);
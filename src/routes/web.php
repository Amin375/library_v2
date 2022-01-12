<?php

use App\Http\Controllers\AlphabetSearchController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookAuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookCopyController;
use App\Http\Controllers\BookGenreController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanCartController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('search', SearchController::class)->name('search')->middleware('auth');

Route::get('alphabetsearch/{letter}', AlphabetSearchController::class)->name('alphabetsearch')->middleware('auth');

Route::get('notify/{id}', [LoanController::class, 'store'])->name('notify')->middleware('auth');
//Route::get('notify/{id}', [LoanController::class, 'store'])->name('notify');

//Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//Route::get('/dashboard/{name}', [DashboardController::class, 'update'])->name('dashboard.update');

Route::get('dashboard/{slug}', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');
Route::get('dashboard/edit/{slug}', [DashboardController::class, 'edit'])->name('dashboard.edit')->middleware('auth');
Route::post('dashboard/update/{user}', [DashboardController::class, 'update'])->name('dashboard.update')->middleware('auth');

Route::get('books', [BookController::class, 'index'])->name('books.index')->middleware('auth');
Route::get('genres', [GenreController::class, 'index'])->name('genres.index')->middleware('auth');
Route::get('authors', [AuthorController::class, 'index'])->name('authors.index')->middleware('auth');

Route::get('book/{slug}', [BookController::class, 'show'])->name('book.show')->middleware('auth');
Route::get('books/genre/{slug}', [BookGenreController::class, 'index'])->name('book.genre')->middleware('auth');
Route::get('books/author/{slug}', [BookAuthorController::class, 'index'])->name('book.author')->middleware('auth');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'wishlist',
    'as' => 'wishlist',
], function () {
    Route::get('index', [WishlistController::class, 'index'])->name('.index');
    Route::post('store/{id}/{slug}', [WishlistController::class, 'store'])->name('.store');
    Route::get('destroy/{id}', [WishlistController::class, 'destroy'])->name('.destroy');
});

Route::group([
    'middleware' => 'auth',
    'prefix' => 'loans',
    'as' => 'loans',
], function () {
    Route::get('cart', [LoanCartController::class, 'index'])->name('.cart');
    Route::post('store/{id}', [LoanController::class, 'store'])->name('.store');
    Route::get('show/{id}', [LoanController::class, 'show'])->name('.show');

    Route::post('cart/store/{id}/{slug}', [LoanCartController::class, 'store'])->name('.cart.store');
    Route::get('cart/destroy/{id}', [LoanCartController::class, 'destroy'])->name('.cart.destroy');
});

Route::group([
    'middleware' => 'admin',
    'prefix' => 'admin',
    'as' => 'admin',
], function () {

    Route::group([
        'prefix' => 'book',
        'as' => '.book',
    ], function () {
        Route::get('create', [BookController::class, 'create'])->name('.create');
        Route::get('edit/{id}', [BookController::class, 'edit'])->name('.edit');
        Route::post('store', [BookController::class, 'store'])->name('.store');
        Route::post('update/{id}', [BookController::class, 'update'])->name('.update');
        Route::get('destroy/{book:id}', [BookController::class, 'destroy'])->name('.destroy');
    });

    Route::group([
        'prefix' => 'author',
        'as' => '.author',
    ], function () {
        Route::get('create', [AuthorController::class, 'create'])->name('.create');
        Route::get('edit/{id}', [AuthorController::class, 'edit'])->name('.edit');
        Route::post('store', [AuthorController::class, 'store'])->name('.store');
        Route::post('update/{id}', [AuthorController::class, 'update'])->name('.update');
        Route::get('destroy/{author:id}', [AuthorController::class, 'destroy'])->name('.destroy');
    });

    Route::group([
        'prefix' => 'genre',
        'as' => '.genre',
    ], function () {
        Route::get('create', [GenreController::class, 'create'])->name('.create');
        Route::get('edit/{id}', [GenreController::class, 'edit'])->name('.edit');
        Route::post('store', [GenreController::class, 'store'])->name('.store');
        Route::post('update/{id}', [GenreController::class, 'update'])->name('.update');
        Route::get('destroy/{id}', [GenreController::class, 'destroy'])->name('.destroy');
    });

    Route::group([
        'prefix' => 'book_copies',
        'as' => '.book_copies'
    ], function () {
        Route::get('/', [BookCopyController::class, 'index'])->name('.index');
        Route::get('store/{id}', [BookCopyController::class, 'store'])->name('.store');
        Route::get('destroy/{id}', [BookCopyController::class, 'destroy'])->name('.destroy');
    });
});

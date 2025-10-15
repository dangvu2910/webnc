<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('user.index');
});

Route::get('/index', function () {
    return view('user.index');
});
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/add-sample', [CartController::class, 'addSample'])->name('cart.add.sample');

Route::get('/checkout', function () {
    return view('user.checkout');
});

Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/men', function () {
    return view('user.men');
});

Route::get('/women', function () {
    return view('user.women');
});
Route::get('/search', [SearchController::class, 'index'])->name('search');
use App\Http\Controllers\Admin\AdminPageController;

Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.index')->name('admin.dashboard');
    Route::view('/dashboard', 'admin.index');
    Route::view('/forms', 'admin.forms')->name('admin.forms');
    Route::get('/{page}', [AdminPageController::class, 'show'])
        ->where('page', '.*')
        ->name('admin.any');
});




<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Auth
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Front controllers
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;

// Admin controllers
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| Health check / quick test
|--------------------------------------------------------------------------
*/
Route::get('/test-admin', function () {
    return 'Laravel is working! Server time: ' . now();
});

/*
|--------------------------------------------------------------------------
| Front site
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index']);
Route::get('/index', [ProductController::class, 'index']);

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/account', function () {
    return view('user.account');
})->middleware('auth')->name('account');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/add-sample', [CartController::class, 'addSample'])->name('cart.add.sample');

Route::view('/checkout', 'user.checkout');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

Route::view('/men', 'user.men');
Route::view('/women', 'user.women');

Route::get('/search', [SearchController::class, 'index'])->name('search');

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|
| Một số template mong đợi route tên 'admin' nên mình giữ alias này trỏ
| về dashboard.
*/
Route::redirect('/admin', '/admin/dashboard')->name('admin');

Route::prefix('admin')->name('admin.')->middleware(['auth','is_admin'])->group(function () {
    // Dashboard
    Route::view('/', 'admin.index')->name('dashboard');
    Route::view('/dashboard', 'admin.index');

    // Products
    Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Categories
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // Users
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

    // Static pages / samples
    Route::view('charts', 'admin.charts');
    Route::view('tables', 'admin.tables');
});

/*
|--------------------------------------------------------------------------
| Local-only helpers (debug/impersonate)
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::get('/admin/debug', function (Request $request) {
        $user = auth()->user();
        return response()->json([
            'auth_check' => auth()->check(),
            'user_id' => auth()->id(),
            'user' => $user ? [
                'id' => $user->id,
                'email' => $user->email ?? null,
                'username' => $user->username ?? null,
                'is_admin' => (bool) ($user->is_admin ?? false),
            ] : null,
            'session_cookie_name' => config('session.cookie'),
            'session_cookie_value' => $request->cookie(config('session.cookie')),
            'server_session_id' => session()->getId(),
        ]);
    });

    Route::get('/admin/impersonate-admin', function () {
        $email = env('APP_ADMIN_EMAIL', 'admin@example.com');
        $user = \App\Models\User::where('email', $email)->first();
        if (!$user) {
            return response('Admin user not found: ' . $email, 404);
        }
        auth()->loginUsingId($user->id);
        session()->regenerate();
        return redirect('/admin');
    });
}

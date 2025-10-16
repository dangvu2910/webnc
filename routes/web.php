<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/test-admin', function () {
    return 'Laravel is working! Server time: ' . now();
});

use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::get('/index', [ProductController::class, 'index']);
// Product detail
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// User account page
Route::get('/account', function () {
    return view('user.account');
})->middleware('auth')->name('account');
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
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\AdminDashboardController;

// Provide a stable named route `admin` used by some templates/packages that
// expect a route named `admin`. Redirect it to the dashboard route.
Route::redirect('/admin', '/admin/dashboard')->name('admin');

Route::prefix('admin')->name('admin.')->middleware(['auth','is_admin'])->group(function () {
    // Dashboard - Connected to Database
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    
    // Products Management
    Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Categories Management
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Users Management
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Orders Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Keep existing static pages
    Route::view('forms', 'admin.forms')->name('forms');
    Route::view('charts', 'admin.charts');
    Route::view('tables', 'admin.tables');
    
    // Pages submenu (catch-all at the end)
    Route::get('pages/{page}', [AdminPageController::class, 'show'])->where('page', '.*')->name('pages.show');
});

// Local-only debug route to inspect authentication/session state when
// troubleshooting admin access. Only enabled in the local environment.
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

    // Local-only helper: impersonate the seeded admin user so you can verify
    // the admin UI. This will log in the user with email from .env or default
    // and redirect to /admin. Only available in local environment.
    Route::get('/admin/impersonate-admin', function () {
        $email = env('APP_ADMIN_EMAIL', 'admin@example.com');
        $user = \App\Models\User::where('email', $email)->first();
        if (! $user) {
            return response('Admin user not found: ' . $email, 404);
        }
        auth()->loginUsingId($user->id);
        session()->regenerate();
        return redirect('/admin');
    });
}


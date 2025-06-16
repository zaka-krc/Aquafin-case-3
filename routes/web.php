<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Redirect home naar dashboard als ingelogd
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// User routes (authentication required)
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Materials (User functionality)
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::get('/materials/{material}', [MaterialController::class, 'show'])->name('materials.show');
    Route::post('/materials/{material}/add-to-cart', [MaterialController::class, 'addToCart'])->name('materials.add-to-cart');
    
    // Cart
    Route::get('/cart', [MaterialController::class, 'cart'])->name('materials.cart');
    Route::delete('/cart/{material}', [MaterialController::class, 'removeFromCart'])->name('materials.remove-from-cart');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes (admin middleware required)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Material management
    Route::get('/materials', [AdminController::class, 'materials'])->name('materials');
    Route::get('/materials/create', [AdminController::class, 'createMaterial'])->name('materials.create');
    Route::post('/materials', [AdminController::class, 'storeMaterial'])->name('materials.store');
    Route::get('/materials/{material}', [AdminController::class, 'showMaterial'])->name('materials.show');
    Route::match(['GET', 'POST'], '/materials/{material}/edit', [AdminController::class, 'editMaterial'])->name('materials.edit');
    Route::delete('/materials/{material}', [AdminController::class, 'deleteMaterial'])->name('materials.delete');
    Route::patch('/materials/{material}/stock', [AdminController::class, 'updateStock'])->name('materials.update-stock');
    
    // Order management
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
});

require __DIR__.'/auth.php';
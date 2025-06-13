<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// Home redirect
Route::get('/', function () {
    if (auth()->check()) {
        return view('home');
    }
    return redirect()->route('login');
})->name('home');

// User routes (authentication required)
Route::middleware('auth')->group(function () {
    
    // Materials (User functionality)
    Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
    Route::post('/materials/{material}/add-to-cart', [MaterialController::class, 'addToCart'])->name('materials.add-to-cart');
    
    // Cart
    Route::get('/cart', [MaterialController::class, 'cart'])->name('materials.cart');
    Route::delete('/cart/{material}', [MaterialController::class, 'removeFromCart'])->name('materials.remove-from-cart');
    
    // Orders
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Admin routes (admin middleware required)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/materials', [AdminController::class, 'materials'])->name('materials');
    Route::get('/materials/create', [AdminController::class, 'createMaterial'])->name('materials.create');
    Route::post('/materials', [AdminController::class, 'storeMaterial'])->name('materials.store');
    Route::get('/materials/{material}/edit', [AdminController::class, 'editMaterial'])->name('materials.edit');
    Route::patch('/materials/{material}', [AdminController::class, 'updateMaterial'])->name('materials.update');
    Route::delete('/materials/{material}', [AdminController::class, 'deleteMaterial'])->name('materials.delete');
});

require __DIR__.'/auth.php';
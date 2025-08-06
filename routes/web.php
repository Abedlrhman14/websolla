<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::latest()->get();
    return view('home' , compact('products'));
});
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');//to add product to cad
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');//the card page
Route::post('/checkout' , [CartController::class , 'storeOrder'])->name('cart.storeOrder');//to send orders
Route::get('/dashboard', function () {
    return redirect()->route('products.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/orders', [CartController::class, 'showOrders'])->name('orders');//orders dashbord
    Route::resource('products', ProductController::class);// product Route

});

require __DIR__.'/auth.php';

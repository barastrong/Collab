<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Barang Routes
Route::get('/', [BarangController::class, 'index'])->name('index');
Route::get('/barang-category', [BarangController::class, 'category'])->name('barang');
Route::get('/barang-table', [BarangController::class, 'table'])->name('tablebarang');
Route::delete('/delete/{id}', [BarangController::class, 'delete'])->name('delete');
Route::get('/barangadd', [BarangController::class, 'add'])->name('barangadd');
Route::post('/barangstore', [BarangController::class, 'store'])->name('barangstore');
Route::get('/barang/search', [BarangController::class, 'search'])->name('barang.search');
Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('edit');
Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');

//User Routes
Route::get('/users', [UserController::class, 'index'])->name('user-table');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');

// Purchase routes
Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
        Route::get('purchases/create/{barang}', [PurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/', [PurchaseController::class, 'store'])->name('purchases.store');
        Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
        Route::patch('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
        Route::get('ordertable', [PurchaseController::class, 'table'])->name('ordertable');
        Route::post('/purchases/{purchase}/update-status', [PurchaseController::class, 'updateStatus'])->name('purchases.updateStatus');


    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BarangController::class, 'index'])->name('index');
Route::get('/barang-category', [BarangController::class, 'category'])->name('barang');
Route::get('/barang-table', [BarangController::class, 'table'])->name('tablebarang');
Route::get('/barangadd', [BarangController::class, 'add'])->name('barangadd');
Route::post('/barangstore', [BarangController::class, 'store'])->name('barangstore');
Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('edit');
Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');

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
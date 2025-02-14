<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;

Route::get('/barang-table', [BarangController::class, 'table'])->name('tablebarang');
Route::post('/barangstore', [BarangController::class, 'store'])->name('barangstore');
Route::get('/barangadd', [BarangController::class, 'add'])->name('barangadd');
Route::get('/barang', [BarangController::class, 'index'])->name('barang');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

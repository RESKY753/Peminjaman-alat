<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\user;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;

// Route Tampilan Form Login (Must be GET and named 'login')
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Route Eksekusi Login
Route::post('/login', [userController::class, 'proseslogin'])->name('login.proses');

// Route Yang Membutuhkan Session Login (Protected)
// =======================ADMIN=============================
Route::middleware(['auth'] == 'admin')->group(function () {
    Route::get('/admin/alat', [AlatController::class, 'index'])->name('dashboardadmin');

    Route::get('/admin/user', [userController::class, 'indexUser']);
    Route::get('/admin/kategori', [KategoriController::class, 'index']);
    Route::get('/admin/log', [LogAktivitasController::class, 'index']);
    Route::post('/admin/user/store', [userController::class, 'store']);
    Route::post('/admin/user/delete/{id}', [userController::class, 'destroy']);
    Route::put('/admin/user/update/{id}', [userController::class, 'update']);
    Route::post('/admin/kategori/store', [KategoriController::class, 'store']);
    Route::post('/admin/kategori/delete/{id}', [KategoriController::class, 'destroy']);
    Route::put('/admin/kategori/update/{id}', [KategoriController::class, 'update']);



    

});

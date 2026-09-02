<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamanController;
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
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/alat', [AlatController::class, 'index'])->name('dashboardadmin');

    Route::get('/admin/user', [userController::class, 'indexUser']);
    Route::get('/admin/kategori', [KategoriController::class, 'index']);
    Route::get('/admin/log', [LogAktivitasController::class, 'index']);
    Route::get('/admin/user/create', [userController::class, 'create']);
    Route::post('/admin/user/store', [userController::class, 'store']);
    Route::post('/admin/user/delete/{id}', [userController::class, 'destroy']);
    Route::get('/admin/user/edit/{id}', [userController::class, 'edit']);
    Route::put('/admin/user/update/{id}', [userController::class, 'update']);
    Route::post('/admin/kategori/store', [KategoriController::class, 'store']);
    Route::post('/admin/kategori/delete/{id}', [KategoriController::class, 'destroy']);
    Route::put('/admin/kategori/update/{id}', [KategoriController::class, 'update']);
    Route::get('/admin/alat/create', [AlatController::class, 'create']);
    Route::post('/admin/alat/store', [AlatController::class, 'store']);
    Route::post('/admin/alat/delete/{id}', [AlatController::class, 'destroy']);
    Route::put('/admin/alat/update/{id}', [AlatController::class, 'update']);
    Route::get('/admin/alat/edit/{id}', [AlatController::class, 'edit']);
    Route::post('/admin/logout', [userController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('/peminjam/katalog', [AlatController::class, 'indexKatalog'])->name('dp');
    Route::get('/peminjam/pinjaman/{id}', [PeminjamanController::class, 'pinjamanSaya']);
    Route::get('/peminjam/katalog/{id}/create', [PeminjamanController::class, 'create']);
    Route::post('/peminjam/pinjam/store', [PeminjamanController::class, 'store']);
});

Route::middleware(['auth', 'role:petugas'])->group(function () {
     Route::get('/petugas/persetujuan', [PeminjamanController::class, 'indexPersetujuan'])->name('dpetugas');
});
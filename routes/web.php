<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\ProfilController;

// Rute untuk halaman utama (guest)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{id}', [HomeController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/galeri/{id}', [HomeController::class, 'galeriDetail'])->name('galeri.detail');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [HomeController::class, 'kirimPesan'])->name('kontak.kirim');

// Rute untuk autentikasi admin
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AuthController::class, 'forgotPassword'])->name('admin.password.email');
Route::get('/admin/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('admin.password.reset');
Route::post('/admin/reset-password', [AuthController::class, 'resetPassword'])->name('admin.password.update');

// Rute untuk admin (tanpa middleware - sesuai sistem asli)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rute untuk    // Admin Galeri routes
    Route::resource('galeri', GaleriController::class);
    Route::get('galeri/{id}/add-photo', [GaleriController::class, 'addPhoto'])->name('galeri.add-photo');
    Route::post('galeri/{id}/store-photo', [GaleriController::class, 'storePhoto'])->name('galeri.store-photo');
    Route::delete('galeri/photo/{id}', [GaleriController::class, 'deletePhoto'])->name('galeri.delete-photo');
    
    // Admin Fasilitas routes
    Route::resource('fasilitas', App\Http\Controllers\Admin\FasilitasController::class);
    
    // Admin Guru routes
    Route::resource('guru', App\Http\Controllers\Admin\GuruController::class);
    
    // Rute untuk manajemen berita
    Route::resource('berita', BeritaController::class);
    
    // Rute untuk manajemen kategori berita
    Route::get('/kategori', [BeritaController::class, 'kategoriIndex'])->name('berita.kategori.index');
    Route::get('/kategori/create', [BeritaController::class, 'kategoriCreate'])->name('berita.kategori.create');
    Route::post('/kategori', [BeritaController::class, 'kategoriStore'])->name('berita.kategori.store');
    Route::get('/kategori/{id}/edit', [BeritaController::class, 'kategoriEdit'])->name('berita.kategori.edit');
    Route::put('/kategori/{id}', [BeritaController::class, 'kategoriUpdate'])->name('berita.kategori.update');
    Route::delete('/kategori/{id}', [BeritaController::class, 'kategoriDestroy'])->name('berita.kategori.destroy');
    
    // Rute untuk manajemen profil sekolah
    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::get('/profil/create', [ProfilController::class, 'create'])->name('profil.create');
    Route::post('/profil', [ProfilController::class, 'store'])->name('profil.store');
    Route::get('/profil/{id}', [ProfilController::class, 'show'])->name('profil.show');
    Route::get('/profil/{id}/edit', [ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil/{id}', [ProfilController::class, 'update'])->name('profil.update');
    Route::delete('/profil/{id}', [ProfilController::class, 'destroy'])->name('profil.destroy');
});

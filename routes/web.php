<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\
{
    AuthController,
    DashboardController,
    GaleriController,
    BeritaController,
    ProfilController,
    ContactController,
    AgendaController as AdminAgendaController
};
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FotoInteractionController;
use App\Http\Controllers\Auth\GuestAuthController;
use App\Http\Controllers\AIChatController;

// Rute untuk halaman utama (guest)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{id}', [HomeController::class, 'beritaDetail'])->name('berita.detail');
Route::post('/berita/{post}/komentar', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('berita.comment.store');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/galeri/{id}', [HomeController::class, 'galeriDetail'])->name('galeri.detail');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/fasilitas-all', [HomeController::class, 'fasilitasAll'])->name('fasilitas.all');
Route::get('/guru-all', [HomeController::class, 'guruAll'])->name('guru.all');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [HomeController::class, 'kirimPesan'])->name('kontak.kirim');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/agenda/{id}', [AgendaController::class, 'show'])->name('agenda.show');
Route::get('/fasilitas', [HomeController::class, 'fasilitasAll'])->name('fasilitas');

// AJAX endpoints for Foto interactions (guest)
Route::prefix('ajax')->group(function () {
    Route::get('/fotos/counts', [FotoInteractionController::class, 'getCounts'])->name('ajax.fotos.counts');
    Route::post('/fotos/{foto}/like', [FotoInteractionController::class, 'incrementLike'])->middleware('auth')->name('ajax.fotos.like');
    Route::post('/fotos/{foto}/unlike', [FotoInteractionController::class, 'decrementLike'])->middleware('auth')->name('ajax.fotos.unlike');
    Route::get('/fotos/{foto}/comments', [FotoInteractionController::class, 'listComments'])->name('ajax.fotos.comments');
    Route::post('/fotos/{foto}/comments', [FotoInteractionController::class, 'addComment'])->name('ajax.fotos.comments.add');
});

// AI Assistant routes
Route::get('/ai', [AIChatController::class, 'index'])->name('ai');
Route::post('/ai/ask', [AIChatController::class, 'ask'])->name('ai.ask');
Route::post('/ai/stream', [AIChatController::class, 'stream'])->name('ai.stream');

// Guest Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [GuestAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [GuestAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [GuestAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [GuestAuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [GuestAuthController::class, 'logout'])->middleware('auth')->name('logout');

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
    
    // Admin Galeri routes
    Route::resource('galeri', GaleriController::class);
    Route::get('galeri/{id}/add-photo', [GaleriController::class, 'addPhoto'])->name('galeri.add-photo');
    Route::post('galeri/{id}/store-photo', [GaleriController::class, 'storePhoto'])->name('galeri.store-photo');
    Route::put('galeri/photo/{id}', [GaleriController::class, 'updatePhoto'])->name('galeri.update-photo');
    Route::delete('galeri/photo/{id}', [GaleriController::class, 'deletePhoto'])->name('galeri.delete-photo');
    
    // Contact routes
    Route::get('contact', [ContactController::class, 'index'])->name('contact.index');
    Route::get('contact/{id}', [ContactController::class, 'show'])->name('contact.show');
    Route::patch('contact/{id}/read', [ContactController::class, 'markAsRead'])->name('contact.read');
    Route::patch('contact/{id}/unread', [ContactController::class, 'markAsUnread'])->name('contact.unread');
    Route::delete('contact/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
    
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
    
    // Admin Profil routes
    Route::resource('profil', ProfilController::class);
    
    // Admin Agenda routes
    Route::resource('agenda', AdminAgendaController::class);
    Route::patch('agenda/{agenda}/toggle-status', [AdminAgendaController::class, 'toggleStatus'])->name('agenda.toggle-status');
});

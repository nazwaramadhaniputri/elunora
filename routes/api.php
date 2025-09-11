<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProfilController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\GuruController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public API Routes
Route::prefix('v1')->group(function () {
    // Profile API
    Route::get('/profile', [HomeController::class, 'profil']);
    
    // Posts/Berita API
    Route::get('/posts', [HomeController::class, 'berita']);
    Route::get('/posts/{id}', [HomeController::class, 'beritaDetail']);
    
    // Gallery API
    Route::get('/gallery', [HomeController::class, 'galeri']);
    Route::get('/gallery/{id}', [HomeController::class, 'galeriDetail']);
    
    // Contact API
    Route::post('/contact', [HomeController::class, 'kirimPesan']);
    
    // Facilities API
    Route::get('/facilities', [HomeController::class, 'fasilitasAll']);
    
    // Teachers API
    Route::get('/teachers', [HomeController::class, 'guruAll']);
});

// Admin API Routes
Route::middleware(['auth:sanctum'])->prefix('admin/v1')->group(function () {
    // Profile Management
    Route::get('/profile', [ProfilController::class, 'index']);
    Route::post('/profile', [ProfilController::class, 'store']);
    Route::put('/profile/{id}', [ProfilController::class, 'update']);
    
    // Posts Management
    Route::get('/posts', [BeritaController::class, 'index']);
    Route::post('/posts', [BeritaController::class, 'store']);
    Route::put('/posts/{id}', [BeritaController::class, 'update']);
    Route::delete('/posts/{id}', [BeritaController::class, 'destroy']);
    
    // Gallery Management
    Route::get('/gallery', [GaleriController::class, 'index']);
    Route::post('/gallery', [GaleriController::class, 'store']);
    Route::put('/gallery/{id}', [GaleriController::class, 'update']);
    Route::delete('/gallery/{id}', [GaleriController::class, 'destroy']);
    
    // Facilities Management
    Route::get('/facilities', [FasilitasController::class, 'index']);
    Route::post('/facilities', [FasilitasController::class, 'store']);
    Route::put('/facilities/{id}', [FasilitasController::class, 'update']);
    Route::delete('/facilities/{id}', [FasilitasController::class, 'destroy']);
    
    // Teachers Management
    Route::get('/teachers', [GuruController::class, 'index']);
    Route::post('/teachers', [GuruController::class, 'store']);
    Route::put('/teachers/{id}', [GuruController::class, 'update']);
    Route::delete('/teachers/{id}', [GuruController::class, 'destroy']);
});

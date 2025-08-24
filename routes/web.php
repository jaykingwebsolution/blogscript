<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.index');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected by admin middleware in controller)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Music Management
    Route::get('/music', [AdminController::class, 'musicIndex'])->name('music.index');
    Route::get('/music/create', [AdminController::class, 'musicCreate'])->name('music.create');
    Route::post('/music', [AdminController::class, 'musicStore'])->name('music.store');
    Route::get('/music/{music}/edit', [AdminController::class, 'musicEdit'])->name('music.edit');
    Route::put('/music/{music}', [AdminController::class, 'musicUpdate'])->name('music.update');
    Route::delete('/music/{music}', [AdminController::class, 'musicDestroy'])->name('music.destroy');
    
    // Artist Management
    Route::get('/artists', [AdminController::class, 'artistIndex'])->name('artists.index');
    Route::get('/artists/create', [AdminController::class, 'artistCreate'])->name('artists.create');
    Route::post('/artists', [AdminController::class, 'artistStore'])->name('artists.store');
    Route::get('/artists/{artist}/edit', [AdminController::class, 'artistEdit'])->name('artists.edit');
    Route::put('/artists/{artist}', [AdminController::class, 'artistUpdate'])->name('artists.update');
    Route::delete('/artists/{artist}', [AdminController::class, 'artistDestroy'])->name('artists.destroy');
    
    // User Management
    Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
    Route::post('/users/{user}/approve', [AdminController::class, 'userApprove'])->name('users.approve');
    Route::post('/users/{user}/suspend', [AdminController::class, 'userSuspend'])->name('users.suspend');
});
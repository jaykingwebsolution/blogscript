<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ArtistRequestController;

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

// Music Routes
Route::get('/music', [MusicController::class, 'index'])->name('music.index');
Route::get('/music/{slug}', [MusicController::class, 'show'])->name('music.show');

// Artists Routes
Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{username}', [ArtistController::class, 'show'])->name('artists.show');

// Videos Routes
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');
Route::get('/videos/{slug}', [VideoController::class, 'show'])->name('videos.show');

// Blog/News Routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// Static Pages
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContactForm'])->name('contact.submit');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/privacy-policy', [PageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/dmca', [PageController::class, 'dmca'])->name('dmca');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Newsletter
Route::post('/newsletter/subscribe', [PageController::class, 'newsletterSubscribe'])->name('newsletter.subscribe');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard and Profile Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
    
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::put('/dashboard/password', [ProfileController::class, 'updatePassword'])->name('dashboard.password.update');
    
    // Subscription Routes
    Route::get('/dashboard/subscription', [SubscriptionController::class, 'index'])->name('dashboard.subscription');
    Route::post('/subscription/initialize', [SubscriptionController::class, 'initializePayment'])->name('subscription.initialize');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    
    // Artist Request Routes
    Route::get('/dashboard/verification', [ArtistRequestController::class, 'verificationIndex'])->name('dashboard.verification');
    Route::post('/dashboard/verification', [ArtistRequestController::class, 'verificationStore'])->name('dashboard.verification.store');
    Route::get('/dashboard/trending', [ArtistRequestController::class, 'trendingIndex'])->name('dashboard.trending');
    Route::post('/dashboard/trending', [ArtistRequestController::class, 'trendingStore'])->name('dashboard.trending.store');
});

// Artist Routes (Authenticated Artists and Record Labels)
Route::prefix('artist')->name('artist.')->middleware('auth')->group(function () {
    Route::get('/music', [\App\Http\Controllers\Artist\MusicController::class, 'index'])->name('music.index');
    Route::get('/music/create', [\App\Http\Controllers\Artist\MusicController::class, 'create'])->name('music.create');
    Route::post('/music', [\App\Http\Controllers\Artist\MusicController::class, 'store'])->name('music.store');
    Route::get('/music/{music}', [\App\Http\Controllers\Artist\MusicController::class, 'show'])->name('music.show');
    Route::get('/music/{music}/edit', [\App\Http\Controllers\Artist\MusicController::class, 'edit'])->name('music.edit');
    Route::put('/music/{music}', [\App\Http\Controllers\Artist\MusicController::class, 'update'])->name('music.update');
    Route::delete('/music/{music}', [\App\Http\Controllers\Artist\MusicController::class, 'destroy'])->name('music.destroy');
});

// Paystack Callback Route
Route::get('/paystack/callback', [SubscriptionController::class, 'handleCallback'])->name('subscription.callback');

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
    Route::post('/music/{music}/approve', [AdminController::class, 'musicApprove'])->name('music.approve');
    Route::post('/music/{music}/reject', [AdminController::class, 'musicReject'])->name('music.reject');
    
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
    
    // Subscription Management
    Route::get('/subscriptions', [AdminController::class, 'subscriptionIndex'])->name('subscriptions.index');
    
    // Verification Request Management
    Route::get('/verification', [AdminController::class, 'verificationIndex'])->name('verification.index');
    Route::post('/verification/{request}/approve', [AdminController::class, 'verificationApprove'])->name('verification.approve');
    Route::post('/verification/{request}/reject', [AdminController::class, 'verificationReject'])->name('verification.reject');
    
    // Trending Request Management
    Route::get('/trending', [AdminController::class, 'trendingIndex'])->name('trending.index');
    Route::post('/trending/{request}/approve', [AdminController::class, 'trendingApprove'])->name('trending.approve');
    Route::post('/trending/{request}/reject', [AdminController::class, 'trendingReject'])->name('trending.reject');
});
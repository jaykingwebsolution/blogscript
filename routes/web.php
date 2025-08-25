<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\PlanController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\Auth\RoleBasedRegisterController;
use App\Http\Controllers\Dashboard\ListenerDashboardController;
use App\Http\Controllers\SpotifyPostController;

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

// Preview Routes (for testing without database)
Route::get('/admin-preview', function () {
    return view('admin-preview');
})->name('admin.preview');

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
Route::get('/register', [RoleBasedRegisterController::class, 'showRoleSelection'])->name('register');
Route::get('/register/{role}', [RoleBasedRegisterController::class, 'showRegisterForm'])->name('register.role');
Route::post('/register/{role}', [RoleBasedRegisterController::class, 'register'])->name('register.role.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Playlist Routes
Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');

// Dashboard and Profile Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Redirect to role-specific dashboard
        if ($user->isListener()) {
            return app(ListenerDashboardController::class)->index();
        } elseif ($user->isArtist()) {
            return redirect()->route('artist.dashboard');
        } elseif ($user->isRecordLabel()) {
            return redirect()->route('label.dashboard');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('dashboard.index');
    })->name('dashboard');
    
    // Playlist Management
    Route::get('/my-playlists', [PlaylistController::class, 'myPlaylists'])->name('playlists.my-playlists');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
    Route::post('/playlists/{playlist}/music', [PlaylistController::class, 'addMusic'])->name('playlists.add-music');
    Route::delete('/playlists/{playlist}/music/{music}', [PlaylistController::class, 'removeMusic'])->name('playlists.remove-music');
    Route::put('/playlists/{playlist}/order', [PlaylistController::class, 'updateMusicOrder'])->name('playlists.update-order');
    
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

    // Distribution Routes
    Route::get('/distribution/submit', [App\Http\Controllers\DistributionController::class, 'create'])->name('distribution.create');
    Route::post('/distribution/submit', [App\Http\Controllers\DistributionController::class, 'store'])->name('distribution.store');
    Route::get('/distribution/my-submissions', [App\Http\Controllers\DistributionController::class, 'mySubmissions'])->name('distribution.my-submissions');
    Route::get('/distribution/my-submissions/{distributionRequest}', [App\Http\Controllers\DistributionController::class, 'show'])->name('distribution.show');
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
    
    // Media Routes
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/media/upload', [MediaController::class, 'create'])->name('media.upload');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::get('/media/{media}', [MediaController::class, 'show'])->name('media.show');
    Route::get('/media/{media}/edit', [MediaController::class, 'edit'])->name('media.edit');
    Route::put('/media/{media}', [MediaController::class, 'update'])->name('media.update');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
});

// Paystack Callback Route
Route::get('/paystack/callback', [SubscriptionController::class, 'handleCallback'])->name('subscription.callback');

// Admin Routes (Protected by admin middleware in controller)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Plan Management Routes
    Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
    Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
    Route::get('/plans/{plan}/edit', [PlanController::class, 'edit'])->name('plans.edit');
    Route::put('/plans/{plan}', [PlanController::class, 'update'])->name('plans.update');
    Route::delete('/plans/{plan}', [PlanController::class, 'destroy'])->name('plans.destroy');
    
    // Media Management Routes
    Route::get('/media', [AdminController::class, 'mediaIndex'])->name('media.index');
    Route::post('/media/{media}/approve', [AdminController::class, 'mediaApprove'])->name('media.approve');
    Route::post('/media/{media}/reject', [AdminController::class, 'mediaReject'])->name('media.reject');
    
    // Notification Management Routes
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [AdminNotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('notifications.store');
    Route::get('/notifications/{adminNotification}/edit', [AdminNotificationController::class, 'edit'])->name('notifications.edit');
    Route::put('/notifications/{adminNotification}', [AdminNotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{adminNotification}', [AdminNotificationController::class, 'destroy'])->name('notifications.destroy');
    
    // Music Management
    Route::get('/music', [AdminController::class, 'musicIndex'])->name('music.index');
    Route::get('/music/create', [AdminController::class, 'musicCreate'])->name('music.create');
    Route::post('/music', [AdminController::class, 'musicStore'])->name('music.store');
    Route::get('/music/{music}/edit', [AdminController::class, 'musicEdit'])->name('music.edit');
    Route::put('/music/{music}', [AdminController::class, 'musicUpdate'])->name('music.update');
    Route::delete('/music/{music}', [AdminController::class, 'musicDestroy'])->name('music.destroy');
    Route::post('/music/{music}/approve', [AdminController::class, 'musicApprove'])->name('music.approve');
    Route::post('/music/{music}/reject', [AdminController::class, 'musicReject'])->name('music.reject');
    Route::post('/music/{music}/feature', [AdminController::class, 'musicFeature'])->name('music.feature');
    Route::post('/music/{music}/unfeature', [AdminController::class, 'musicUnfeature'])->name('music.unfeature');
    
    // Artist Management
    Route::get('/artists', [AdminController::class, 'artistIndex'])->name('artists.index');
    Route::get('/artists/create', [AdminController::class, 'artistCreate'])->name('artists.create');
    Route::post('/artists', [AdminController::class, 'artistStore'])->name('artists.store');
    Route::get('/artists/{artist}/edit', [AdminController::class, 'artistEdit'])->name('artists.edit');
    Route::put('/artists/{artist}', [AdminController::class, 'artistUpdate'])->name('artists.update');
    Route::delete('/artists/{artist}', [AdminController::class, 'artistDestroy'])->name('artists.destroy');
    
    // User Management
    Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('users.store');
    Route::get('/users/{user}', [AdminController::class, 'userShow'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'userEdit'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'userUpdate'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'userDestroy'])->name('users.destroy');
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
    
    // Site Settings Management
    Route::get('/settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [\App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/remove-file', [\App\Http\Controllers\Admin\SiteSettingController::class, 'removeFile'])->name('settings.remove-file');

    // Distribution Management
    Route::get('/distribution', [\App\Http\Controllers\Admin\DistributionController::class, 'index'])->name('distribution.index');
    Route::get('/distribution/{distributionRequest}', [\App\Http\Controllers\Admin\DistributionController::class, 'show'])->name('distribution.show');
    Route::post('/distribution/{distributionRequest}/approve', [\App\Http\Controllers\Admin\DistributionController::class, 'approve'])->name('distribution.approve');
    Route::post('/distribution/{distributionRequest}/decline', [\App\Http\Controllers\Admin\DistributionController::class, 'decline'])->name('distribution.decline');
    Route::put('/distribution/{distributionRequest}/status', [\App\Http\Controllers\Admin\DistributionController::class, 'updateStatus'])->name('distribution.update-status');
    Route::delete('/distribution/{distributionRequest}', [\App\Http\Controllers\Admin\DistributionController::class, 'destroy'])->name('distribution.destroy');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [AdminNotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
});

// Spotify Routes
Route::prefix('spotify')->name('spotify.')->group(function () {
    Route::get('/', [SpotifyPostController::class, 'index'])->name('index');
    Route::get('/featured', [SpotifyPostController::class, 'featured'])->name('featured');
    Route::get('/{spotifyPost}', [SpotifyPostController::class, 'show'])->name('show');
});
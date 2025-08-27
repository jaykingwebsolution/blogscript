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
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PaymentController;

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

Route::get('/admin-users-preview', function () {
    $users = collect([
        (object)[
            'id' => 1,
            'name' => 'Test Artist',
            'email' => 'artist@test.com',
            'role' => 'artist',
            'status' => 'approved',
            'verification_status' => 'unverified',
            'artist_stage_name' => 'Test Artist',
            'distribution_price' => 29.99,
            'subscription_plan_id' => null,
            'subscription_status' => 'inactive',
            'subscriptionPlan' => null,
            'approved_at' => now(),
            'created_at' => now(),
        ],
        (object)[
            'id' => 2,
            'name' => 'Test Label',
            'email' => 'label@test.com',
            'role' => 'record_label',
            'status' => 'pending',
            'verification_status' => 'verified',
            'artist_stage_name' => null,
            'distribution_price' => 49.99,
            'subscription_plan_id' => 1,
            'subscription_status' => 'active',
            'subscriptionPlan' => (object)['name' => 'Premium', 'amount' => 9.99],
            'approved_at' => null,
            'created_at' => now(),
        ],
        (object)[
            'id' => 3,
            'name' => 'Test Listener',
            'email' => 'listener@test.com',
            'role' => 'listener',
            'status' => 'suspended',
            'verification_status' => 'unverified',
            'artist_stage_name' => null,
            'distribution_price' => null,
            'subscription_plan_id' => null,
            'subscription_status' => 'inactive',
            'subscriptionPlan' => null,
            'approved_at' => now(),
            'created_at' => now(),
        ]
    ]);
    
    $pricingPlans = collect([
        (object)['id' => 1, 'name' => 'Basic', 'amount' => 9.99],
        (object)['id' => 2, 'name' => 'Pro', 'amount' => 19.99],
        (object)['id' => 3, 'name' => 'Enterprise', 'amount' => 49.99],
    ]);
    
    return view('users-preview', compact('users', 'pricingPlans'));
})->name('admin.users.preview');

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

// Playlist Routes (public routes)
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
            return redirect()->route('dashboard.artist');
        } elseif ($user->isRecordLabel()) {
            return redirect()->route('dashboard.record-label');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('dashboard.index');
    })->name('dashboard');
    
    // Role-based Dashboard Routes
    Route::get('/dashboard/listener', [ListenerDashboardController::class, 'index'])->name('dashboard.listener');
    Route::get('/dashboard/artist', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'index'])->name('dashboard.artist');
    Route::get('/dashboard/record-label', [\App\Http\Controllers\Dashboard\LabelDashboardController::class, 'index'])->name('dashboard.record-label');
    
    // Listener Dashboard Routes
    Route::prefix('dashboard/listener')->name('dashboard.listener.')->middleware(['auth', 'role:listener'])->group(function () {
        Route::get('/browse', [ListenerDashboardController::class, 'browse'])->name('browse');
        Route::get('/trending', [ListenerDashboardController::class, 'trending'])->name('trending');
        Route::get('/search', [ListenerDashboardController::class, 'search'])->name('search');
        Route::get('/history', [ListenerDashboardController::class, 'history'])->name('history');
    });
    
    // Artist Dashboard Routes
    Route::prefix('dashboard/artist')->name('dashboard.artist.')->middleware(['auth', 'role:artist'])->group(function () {
        Route::get('/analytics', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'analytics'])->name('analytics');
        Route::get('/upload-music', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'showUploadMusic'])->name('upload-music');
        Route::post('/upload-music', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'uploadMusic'])->name('upload-music.store');
        Route::get('/my-songs', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'mySongs'])->name('my-songs');
        Route::get('/my-songs/{music}/edit', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'editSong'])->name('my-songs.edit');
        Route::put('/my-songs/{music}', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'updateSong'])->name('my-songs.update');
        Route::delete('/my-songs/{music}', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'deleteSong'])->name('my-songs.delete');
        Route::get('/earnings', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'earnings'])->name('earnings');
        Route::get('/distribution-history', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'distributionHistory'])->name('distribution-history');
        Route::get('/submit-song', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'showSubmitSong'])->name('submit-song');
        Route::post('/submit-song', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'submitSong'])->name('submit-song.store');
        Route::get('/submit-trending-song', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'showSubmitTrendingSong'])->name('submit-trending-song');
        Route::post('/submit-trending-song', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'submitTrendingSong'])->name('submit-trending-song.store');
        Route::get('/submit-trending-mixtape', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'showSubmitTrendingMixtape'])->name('submit-trending-mixtape');
        Route::post('/submit-trending-mixtape', [\App\Http\Controllers\Dashboard\ArtistDashboardController::class, 'submitTrendingMixtape'])->name('submit-trending-mixtape.store');
    });
    
    // Record Label Dashboard Routes
    Route::prefix('dashboard/record-label')->name('dashboard.record-label.')->middleware(['auth', 'role:record_label'])->group(function () {
        Route::get('/submit-song', [\App\Http\Controllers\Dashboard\LabelDashboardController::class, 'showSubmitSong'])->name('submit-song');
        Route::post('/submit-song', [\App\Http\Controllers\Dashboard\LabelDashboardController::class, 'submitSong'])->name('submit-song.store');
        Route::get('/create-artist', [\App\Http\Controllers\Dashboard\LabelDashboardController::class, 'showCreateArtist'])->name('create-artist');
        Route::post('/create-artist', [\App\Http\Controllers\Dashboard\LabelDashboardController::class, 'createArtist'])->name('create-artist.store');
    });
    
    
    // Playlist Management (moved main CRUD routes here to avoid conflicts)
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
    Route::get('/my-playlists', [PlaylistController::class, 'myPlaylists'])->name('playlists.my-playlists');
    Route::post('/playlists/{playlist}/music', [PlaylistController::class, 'addMusic'])->name('playlists.add-music');
    Route::delete('/playlists/{playlist}/music/{music}', [PlaylistController::class, 'removeMusic'])->name('playlists.remove-music');
    Route::put('/playlists/{playlist}/order', [PlaylistController::class, 'updateMusicOrder'])->name('playlists.update-order');
    
    Route::get('/dashboard/profile', [ProfileController::class, 'edit'])->name('dashboard.profile');
    Route::put('/dashboard/profile', [ProfileController::class, 'update'])->name('dashboard.profile.update');
    Route::put('/dashboard/password', [ProfileController::class, 'updatePassword'])->name('dashboard.password.update');
    
    // Subscription Routes
    Route::get('/dashboard/subscription', [SubscriptionController::class, 'index'])->name('dashboard.subscription');
    Route::post('/subscription/initialize', [SubscriptionController::class, 'initialize'])->name('subscription.initialize');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
    
    // Library and Liked Songs Routes
    Route::get('/dashboard/library', [App\Http\Controllers\Dashboard\DashboardController::class, 'library'])->name('dashboard.library');
    Route::get('/dashboard/liked-songs', [App\Http\Controllers\Dashboard\DashboardController::class, 'likedSongs'])->name('dashboard.liked-songs');
    Route::post('/music/toggle-like', [App\Http\Controllers\Dashboard\DashboardController::class, 'toggleLike'])->name('music.toggle-like');
    
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
    
    // Payment Routes
    Route::get('/payment/distribution', [\App\Http\Controllers\PaymentController::class, 'showDistributionPayment'])->name('payment.distribution');
    Route::post('/payment/distribution/initialize', [\App\Http\Controllers\PaymentController::class, 'initializeDistributionPayment'])->name('payment.distribution.initialize');
    Route::get('/payment/distribution/callback', [\App\Http\Controllers\PaymentController::class, 'handleDistributionCallback'])->name('payment.distribution.callback');
    Route::post('/payment/distribution/demo', [\App\Http\Controllers\PaymentController::class, 'simulatePaymentSuccess'])->name('payment.distribution.demo');
    Route::get('/payment/plans', [\App\Http\Controllers\PaymentController::class, 'showPlans'])->name('payment.plans');
    Route::get('/payment/distribution', [\App\Http\Controllers\PaymentController::class, 'showDistributionPayment'])->name('payment.distribution');
    Route::get('/payment/distribution/plan/{distributionPricing}', [\App\Http\Controllers\PaymentController::class, 'showDistributionPlan'])->name('payment.distribution-plan');
    Route::get('/payment/subscription', [\App\Http\Controllers\PaymentController::class, 'showSubscriptionPayment'])->name('payment.subscription');
    Route::post('/payment/subscription/initialize', [\App\Http\Controllers\PaymentController::class, 'initializeSubscriptionPayment'])->name('payment.subscription.initialize');
    Route::get('/payment/subscription/callback', [\App\Http\Controllers\PaymentController::class, 'handleSubscriptionCallback'])->name('payment.subscription.callback');
    Route::post('/payment/manual', [\App\Http\Controllers\PaymentController::class, 'submitManualPayment'])->name('payment.manual.submit');
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
    // New enhanced user management routes
    Route::post('/users/{user}/unsuspend', [AdminController::class, 'userUnsuspend'])->name('users.unsuspend');
    Route::post('/users/{user}/unapprove', [AdminController::class, 'userUnapprove'])->name('users.unapprove');
    Route::post('/users/{user}/verify', [AdminController::class, 'userVerify'])->name('users.verify');
    Route::post('/users/{user}/unverify', [AdminController::class, 'userUnverify'])->name('users.unverify');
    Route::post('/users/{user}/assign-plan', [AdminController::class, 'userAssignPlan'])->name('users.assign-plan');
    Route::post('/users/{user}/update-distribution-price', [AdminController::class, 'userUpdateDistributionPrice'])->name('users.update-distribution-price');
    
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
    
    // Pricing Management
    Route::get('/pricing', [\App\Http\Controllers\Admin\PricingController::class, 'index'])->name('pricing.index');
    Route::get('/pricing/create', [\App\Http\Controllers\Admin\PricingController::class, 'create'])->name('pricing.create');
    Route::post('/pricing', [\App\Http\Controllers\Admin\PricingController::class, 'store'])->name('pricing.store');
    Route::get('/pricing/{pricingPlan}/edit', [\App\Http\Controllers\Admin\PricingController::class, 'edit'])->name('pricing.edit');
    Route::put('/pricing/{pricingPlan}', [\App\Http\Controllers\Admin\PricingController::class, 'update'])->name('pricing.update');
    Route::delete('/pricing/{pricingPlan}', [\App\Http\Controllers\Admin\PricingController::class, 'destroy'])->name('pricing.destroy');
    Route::post('/pricing/{pricingPlan}/toggle-status', [\App\Http\Controllers\Admin\PricingController::class, 'toggleStatus'])->name('pricing.toggle-status');
    
    // Manual Payment Management
    Route::get('/manual-payments', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'index'])->name('manual-payments.index');
    Route::get('/manual-payments/{manualPayment}', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'show'])->name('manual-payments.show');
    Route::post('/manual-payments/{manualPayment}/approve', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'approve'])->name('manual-payments.approve');
    Route::post('/manual-payments/{manualPayment}/reject', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'reject'])->name('manual-payments.reject');
    Route::post('/manual-payments/bulk-approve', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'bulkApprove'])->name('manual-payments.bulk-approve');
    Route::get('/manual-payments-settings', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'settings'])->name('manual-payments.settings');
    Route::put('/manual-payments-settings', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'updateSettings'])->name('manual-payments.update-settings');
    Route::get('/manual-payments/{manualPayment}/download', [\App\Http\Controllers\Admin\ManualPaymentController::class, 'downloadProof'])->name('manual-payments.download');
    
    // Payment Settings Management
    Route::get('/payment-settings', [\App\Http\Controllers\Admin\PaymentSettingController::class, 'index'])->name('payment-settings.index');
    Route::put('/payment-settings', [\App\Http\Controllers\Admin\PaymentSettingController::class, 'update'])->name('payment-settings.update');
    Route::post('/payment-settings/test', [\App\Http\Controllers\Admin\PaymentSettingController::class, 'testConnection'])->name('payment-settings.test');
    
    // Page Management (DMCA / Policy Pages)
    Route::get('/pages', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/{page}/edit', [\App\Http\Controllers\Admin\PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('pages.update');
    
    // Distribution Pricing Management
    Route::get('/distribution-pricing', [\App\Http\Controllers\Admin\DistributionPricingController::class, 'index'])->name('distribution-pricing.index');
    Route::get('/distribution-pricing/create', [\App\Http\Controllers\Admin\DistributionPricingController::class, 'create'])->name('distribution-pricing.create');
    Route::post('/distribution-pricing', [\App\Http\Controllers\Admin\DistributionPricingController::class, 'store'])->name('distribution-pricing.store');
    Route::get('/distribution-pricing/{distributionPricing}/edit', [\App\Http\Controllers\Admin\DistributionPricingController::class, 'edit'])->name('distribution-pricing.edit');
    Route::put('/distribution-pricing/{distributionPricing}', [\App\Http\Controllers\Admin\DistributionPricingController::class, 'update'])->name('distribution-pricing.update');
    Route::delete('/distribution-pricing/{distributionPricing}', [\App\Http\Controllers\Admin\DistributionPricingController::class, 'destroy'])->name('distribution-pricing.destroy');
    
    // Spotify Import Management
    Route::get('/spotify-import', [\App\Http\Controllers\Admin\SpotifyImportController::class, 'index'])->name('spotify-import.index');
    Route::post('/spotify-import/search', [\App\Http\Controllers\Admin\SpotifyImportController::class, 'search'])->name('spotify-import.search');
    Route::post('/spotify-import/import', [\App\Http\Controllers\Admin\SpotifyImportController::class, 'importArtist'])->name('spotify-import.import');
    Route::post('/spotify-import/{spotifyArtist}/sync', [\App\Http\Controllers\Admin\SpotifyImportController::class, 'syncArtist'])->name('spotify-import.sync');
    Route::post('/spotify-import/bulk-sync', [\App\Http\Controllers\Admin\SpotifyImportController::class, 'bulkSync'])->name('spotify-import.bulk-sync');
    Route::delete('/spotify-import/{spotifyArtist}', [\App\Http\Controllers\Admin\SpotifyImportController::class, 'deleteArtist'])->name('spotify-import.delete');
    
    // Record Labels Management
    Route::resource('record-labels', \App\Http\Controllers\Admin\RecordLabelController::class);
    Route::post('/record-labels/{id}/approve', [\App\Http\Controllers\Admin\RecordLabelController::class, 'approve'])->name('record-labels.approve');
    Route::post('/record-labels/{id}/suspend', [\App\Http\Controllers\Admin\RecordLabelController::class, 'suspend'])->name('record-labels.suspend');
    
    // Playlists Management
    Route::resource('playlists', \App\Http\Controllers\Admin\PlaylistController::class);
    Route::post('/playlists/{playlist}/feature', [\App\Http\Controllers\Admin\PlaylistController::class, 'feature'])->name('playlists.feature');
    Route::post('/playlists/{playlist}/unfeature', [\App\Http\Controllers\Admin\PlaylistController::class, 'unfeature'])->name('playlists.unfeature');
    Route::post('/playlists/{playlist}/moderate/{action}', [\App\Http\Controllers\Admin\PlaylistController::class, 'moderate'])->name('playlists.moderate');
    Route::post('/playlists/bulk-action', [\App\Http\Controllers\Admin\PlaylistController::class, 'bulkAction'])->name('playlists.bulk-action');
    
    // Content Moderation Management
    Route::prefix('moderation')->name('moderation.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ModerationController::class, 'index'])->name('index');
        Route::get('/music', [\App\Http\Controllers\Admin\ModerationController::class, 'music'])->name('music');
        Route::get('/artists', [\App\Http\Controllers\Admin\ModerationController::class, 'artists'])->name('artists');
        Route::get('/posts', [\App\Http\Controllers\Admin\ModerationController::class, 'posts'])->name('posts');
        Route::get('/comments', [\App\Http\Controllers\Admin\ModerationController::class, 'comments'])->name('comments');
        Route::get('/reports', [\App\Http\Controllers\Admin\ModerationController::class, 'reports'])->name('reports');
        Route::get('/settings', [\App\Http\Controllers\Admin\ModerationController::class, 'settings'])->name('settings');
        Route::get('/logs', [\App\Http\Controllers\Admin\ModerationController::class, 'logs'])->name('logs');
        Route::post('/approve/{type}/{id}', [\App\Http\Controllers\Admin\ModerationController::class, 'approve'])->name('approve');
        Route::post('/reject/{type}/{id}', [\App\Http\Controllers\Admin\ModerationController::class, 'reject'])->name('reject');
        Route::post('/flag/{type}/{id}', [\App\Http\Controllers\Admin\ModerationController::class, 'flag'])->name('flag');
        Route::post('/bulk-action', [\App\Http\Controllers\Admin\ModerationController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/settings', [\App\Http\Controllers\Admin\ModerationController::class, 'updateSettings'])->name('update-settings');
    });
    
    // API Keys & Integration Management
    Route::prefix('api-keys')->name('api-keys.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ApiKeyController::class, 'index'])->name('index');
        Route::get('/spotify', [\App\Http\Controllers\Admin\ApiKeyController::class, 'spotify'])->name('spotify');
        Route::get('/paystack', [\App\Http\Controllers\Admin\ApiKeyController::class, 'paystack'])->name('paystack');
        Route::get('/services', [\App\Http\Controllers\Admin\ApiKeyController::class, 'services'])->name('services');
        Route::get('/logs', [\App\Http\Controllers\Admin\ApiKeyController::class, 'logs'])->name('logs');
        Route::post('/spotify', [\App\Http\Controllers\Admin\ApiKeyController::class, 'updateSpotify'])->name('update-spotify');
        Route::post('/paystack', [\App\Http\Controllers\Admin\ApiKeyController::class, 'updatePaystack'])->name('update-paystack');
        Route::post('/services', [\App\Http\Controllers\Admin\ApiKeyController::class, 'updateServices'])->name('update-services');
        Route::post('/test/{service}', [\App\Http\Controllers\Admin\ApiKeyController::class, 'testConnection'])->name('test-connection');
        Route::post('/generate', [\App\Http\Controllers\Admin\ApiKeyController::class, 'generateApiKey'])->name('generate');
        Route::delete('/revoke/{keyId}', [\App\Http\Controllers\Admin\ApiKeyController::class, 'revokeApiKey'])->name('revoke');
        Route::get('/export', [\App\Http\Controllers\Admin\ApiKeyController::class, 'export'])->name('export');
        Route::post('/import', [\App\Http\Controllers\Admin\ApiKeyController::class, 'import'])->name('import');
    });
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [AdminNotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
});

// Payment Routes
Route::middleware('auth')->prefix('payment')->name('payment.')->group(function () {
    Route::get('/plans', [PaymentController::class, 'showPlans'])->name('plans');
    Route::get('/distribution', [PaymentController::class, 'showDistributionPayment'])->name('distribution');
    Route::get('/subscription', [PaymentController::class, 'showSubscriptionPayment'])->name('subscription');
    
    // Paystack Integration
    Route::post('/distribution/initialize', [PaymentController::class, 'initializeDistributionPayment'])->name('distribution.initialize');
    Route::post('/subscription/initialize', [PaymentController::class, 'initializeSubscriptionPayment'])->name('subscription.initialize');
    Route::get('/distribution/callback', [PaymentController::class, 'handleDistributionCallback'])->name('distribution.callback');
    Route::get('/subscription/callback', [PaymentController::class, 'handleSubscriptionCallback'])->name('subscription.callback');
    
    // Manual Payments
    Route::post('/manual', [PaymentController::class, 'submitManualPayment'])->name('manual.submit');
    
    // Demo
    Route::post('/distribution/demo', [PaymentController::class, 'simulatePaymentSuccess'])->name('distribution.demo');
    Route::post('/subscription/demo', [PaymentController::class, 'simulateSubscriptionSuccess'])->name('subscription.demo');
});

// Like/Unlike Routes  
Route::middleware('auth')->group(function () {
    Route::post('/music/{music}/like', [LikeController::class, 'toggle'])->name('music.like.toggle');
    Route::get('/music/{music}/like-status', [LikeController::class, 'status'])->name('music.like.status');
    Route::get('/music/liked', [LikeController::class, 'index'])->name('music.liked');
    Route::delete('/music/liked/clear', [LikeController::class, 'clear'])->name('music.liked.clear');
});

// Playlist Routes (authenticated - additional actions)
Route::middleware('auth')->group(function () {
    Route::post('/playlists/{playlist}/add-music', [PlaylistController::class, 'addMusic'])->name('playlists.add-music-alt');
    Route::delete('/playlists/{playlist}/remove-music/{music}', [PlaylistController::class, 'removeMusic'])->name('playlists.remove-music-alt');
    Route::put('/playlists/{playlist}/update-order', [PlaylistController::class, 'updateMusicOrder'])->name('playlists.update-order-alt');
});

// Spotify Routes
Route::prefix('spotify')->name('spotify.')->group(function () {
    Route::get('/', [SpotifyPostController::class, 'index'])->name('index');
    Route::get('/featured', [SpotifyPostController::class, 'featured'])->name('featured');
    Route::get('/artist/{artistId}', [SpotifyPostController::class, 'byArtist'])->name('artist');
    Route::get('/{spotifyPost}', [SpotifyPostController::class, 'show'])->name('show');
});
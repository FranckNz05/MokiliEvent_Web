<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Événements publics
Route::prefix('events')->name('events.')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/featured', [EventController::class, 'featured'])->name('featured');
    Route::get('/upcoming', [EventController::class, 'upcoming'])->name('upcoming');
    Route::get('/past', [EventController::class, 'past'])->name('past');
    Route::get('/category/{category:slug}', [EventController::class, 'byCategory'])->name('category');
    Route::get('/location/{location}', [EventController::class, 'byLocation'])->name('location');
    Route::get('/search', [EventController::class, 'search'])->name('search');
    Route::get('/{event:slug}', [EventController::class, 'show'])->name('show');

    // Routes protégées pour les événements
    Route::middleware(['auth', 'role:organizer'])->group(function () {
        Route::get('/create', [EventController::class, 'create'])->name('create');
        Route::post('/', [EventController::class, 'store'])->name('store');
        Route::get('/{event}/edit', [EventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [EventController::class, 'update'])->name('update');
        Route::delete('/{event}', [EventController::class, 'destroy'])->name('destroy');
        Route::post('/{event}/publish', [EventController::class, 'publish'])->name('publish');
        Route::post('/{event}/unpublish', [EventController::class, 'unpublish'])->name('unpublish');
    });

    // Routes pour les tickets
    Route::middleware(['auth'])->group(function () {
        Route::post('/{event}/purchase-tickets', [EventController::class, 'purchaseTickets'])->name('purchase-tickets');
        Route::get('/{event}/tickets', [EventController::class, 'tickets'])->name('tickets');
        Route::get('/{event}/tickets/checkout', [EventController::class, 'ticketCheckout'])->name('tickets.checkout');
        Route::post('/tickets/{ticket}/reserve', [ReservationController::class, 'store'])
            ->name('reservations.store');
    });
});

// Routes des organisateurs
Route::prefix('organisateurs')->name('organizers.')->group(function () {
    Route::get('/', [OrganizerController::class, 'index'])->name('index');
    Route::get('/{organizer:slug}', [OrganizerController::class, 'show'])->name('show');
    Route::middleware(['auth'])->group(function () {
        Route::post('/{organizer}/follow', [OrganizerController::class, 'follow'])->name('follow');
        Route::delete('/{organizer}/unfollow', [OrganizerController::class, 'unfollow'])->name('unfollow');
    });
});

// Blog public
Route::prefix('blog')->name('blogs.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/categorie/{category}', [BlogController::class, 'byCategory'])->name('category');
    Route::get('/{blog:slug}', [BlogController::class, 'show'])->name('show');
    Route::post('/{blog}/like', [BlogController::class, 'like'])->name('blogs.like');
});

// Pages statiques
Route::get('/a-propos', [PageController::class, 'about'])->name('about.index');
Route::get('/contact', [PageController::class, 'contact'])->name('contact.index');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/conditions-utilisation', [PageController::class, 'terms'])->name('legal.terms');
Route::get('/politique-confidentialite', [PageController::class, 'privacy'])->name('legal.privacy');
Route::get('/faq', [PageController::class, 'faq'])->name('faq.index');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

/*
|--------------------------------------------------------------------------
| Routes d'Authentification
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('connexion', [AuthenticatedSessionController::class, 'create'])->name('auth.login');
    Route::post('connexion', [AuthenticatedSessionController::class, 'store']);
    Route::get('inscription', [RegisteredUserController::class, 'create'])->name('auth.register');
    Route::post('inscription', [RegisteredUserController::class, 'store']);
    Route::get('mot-de-passe/reinitialiser', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('mot-de-passe/email', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('mot-de-passe/reinitialiser/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('mot-de-passe/reinitialiser', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('deconnexion', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});

/*
|--------------------------------------------------------------------------
| Routes Authentifiées
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil utilisateur
    Route::prefix('mon-profil')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::get('/mes-billets', [ProfileController::class, 'tickets'])->name('tickets');
        Route::get('/mes-evenements', [ProfileController::class, 'events'])->name('events');
    });

    // Gestion des commandes et réservations
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::post('/tickets/{ticket}/reserve', [ReservationController::class, 'store'])->name('store');
        Route::put('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel');
    });

    // Routes des commandes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    });

    // Routes de paiement
    Route::middleware(['auth'])->group(function () {
        Route::prefix('payments')->name('payments.')->group(function () {
            Route::get('/history', [PaymentController::class, 'history'])->name('history');
            Route::get('/{order}/process', [PaymentController::class, 'process'])->name('process');
            Route::post('/{order}/store', [PaymentController::class, 'store'])->name('store');
            Route::get('/{payment}/success', [PaymentController::class, 'success'])->name('success');
            Route::get('/{payment}/failed', [PaymentController::class, 'failed'])->name('failed');
            Route::post('/{order}/callback', [PaymentController::class, 'callback'])->name('callback');
        });
    });

    // Interactions (commentaires, likes, vues)
    Route::prefix('interactions')->group(function () {
        Route::post('/events/{event}/comments', [CommentController::class, 'store'])->name('events.comments.store');
        Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('blogs.comments.store');
        Route::post('/events/{event}/likes', [LikeController::class, 'store'])->name('events.likes.store');
        Route::post('/blogs/{blog}/likes', [LikeController::class, 'store'])->name('blogs.likes.store');
        Route::get('/events/{event}/views', [ViewController::class, 'increment'])->name('events.views.increment');
        Route::get('/blogs/{blog}/views', [ViewController::class, 'increment'])->name('blogs.views.increment');
    });

    // Routes pour les blogs
    Route::post('/blogs/{blog}/like', [BlogController::class, 'like'])->name('blogs.like');
    Route::post('/blogs/{blog}/comment', [BlogController::class, 'comment'])->name('blogs.comment');
    Route::get('/blogs/{blog}/share', [BlogController::class, 'share'])->name('blogs.share');
    Route::get('/blogs/category/{category}', [BlogController::class, 'byCategory'])->name('blogs.category');
});

/*
|--------------------------------------------------------------------------
| Routes Organisateur
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:organizer'])->prefix('organisateur')->name('organizer.')->group(function () {
    Route::get('/tableau-de-bord', [App\Http\Controllers\Organizer\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistiques', [App\Http\Controllers\Organizer\StatsController::class, 'index'])->name('stats');
    Route::get('/paiements', [App\Http\Controllers\Organizer\PaymentController::class, 'index'])->name('payments');

    // Gestion des événements de l'organisateur
    Route::prefix('evenements')->name('events.')->group(function () {
        Route::get('/', [EventController::class, 'myEvents'])->name('my-events');
        Route::post('/{event}/approuver', [EventController::class, 'approve'])->name('approve');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Gestion des événements
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/pending', [App\Http\Controllers\Admin\EventController::class, 'pending'])->name('pending');
        Route::post('/{event}/approve', [App\Http\Controllers\Admin\EventController::class, 'approve'])->name('approve');
    });

    // Paramètres du site
    Route::prefix('parametres')->name('settings.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('store');
        Route::put('/{parametre}', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('update');
        Route::delete('/{parametre}', [App\Http\Controllers\Admin\SettingController::class, 'destroy'])->name('destroy');
        Route::post('/mise-a-jour-multiple', [App\Http\Controllers\Admin\SettingController::class, 'bulkUpdate'])->name('bulk-update');
        Route::get('/export', [App\Http\Controllers\Admin\SettingController::class, 'export'])->name('export');
        Route::post('/import', [App\Http\Controllers\Admin\SettingController::class, 'import'])->name('import');
    });

    // Gestion des modèles d'emails
    Route::resource('modeles-emails', App\Http\Controllers\Admin\EmailTemplateController::class);
    Route::post('modeles-emails/{modele}/aperçu', [App\Http\Controllers\Admin\EmailTemplateController::class, 'preview'])->name('modeles-emails.preview');
    Route::post('modeles-emails/{modele}/dupliquer', [App\Http\Controllers\Admin\EmailTemplateController::class, 'duplicate'])->name('modeles-emails.duplicate');

    // Gestion des traductions
    Route::prefix('traductions')->name('traductions.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\TranslationController::class, 'store'])->name('store');
        Route::put('/{traduction}', [App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('update');
        Route::delete('/{traduction}', [App\Http\Controllers\Admin\TranslationController::class, 'destroy'])->name('destroy');
        Route::post('/import', [App\Http\Controllers\Admin\TranslationController::class, 'import'])->name('import');
        Route::get('/export', [App\Http\Controllers\Admin\TranslationController::class, 'export'])->name('export');
        Route::post('/synchroniser', [App\Http\Controllers\Admin\TranslationController::class, 'sync'])->name('sync');
    });

    // Logs et monitoring
    Route::prefix('logs')->name('logs.')->group(function () {
        Route::get('/activites', [App\Http\Controllers\Admin\LogController::class, 'activities'])->name('activities');
        Route::get('/erreurs', [App\Http\Controllers\Admin\LogController::class, 'errors'])->name('errors');
        Route::get('/audit', [App\Http\Controllers\Admin\LogController::class, 'audit'])->name('audit');
    });
});

// Routes d'authentification avec vérification OTP
Route::get('verification', [RegisterController::class, 'showVerificationForm'])->name('verification.notice');
Route::post('verification/verify', [RegisterController::class, 'verifyOTP'])->name('verification.verify');
Route::post('verification/resend', [RegisterController::class, 'resendOTP'])->name('verification.resend');

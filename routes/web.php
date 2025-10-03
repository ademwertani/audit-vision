<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController as PublicContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\Admin\StatController as AdminStatController;
// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');
// Pages publiques
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/team', fn() => view('pages.team'))->name('team');
Route::get('/testimonials', fn() => view('pages.testimonial'))->name('testimonials');
Route::get('/404', fn() => view('pages.404'))->name('404');
Route::get('/quote', [QuoteController::class, 'create'])->name('pages.quote'); // affiche le formulaire
Route::post('/quote', [QuoteController::class, 'store'])->name('pages.quote'); // enregistre les données
// Services publics
Route::get('/services', [App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [App\Http\Controllers\ServiceController::class, 'show'])->name('services.show');
// Contact public
Route::get('/contact', [PublicContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');
// Authentification
Auth::routes();
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->middleware(['auth', 'role:admin'])->name('admin.logout');
// Groupe admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('services', ServiceController::class);
    Route::resource('contacts', AdminContactController::class);
    Route::resource('projects', AdminProjectController::class);
    Route::resource('blogs', AdminBlogController::class);
    Route::resource('quotes', AdminQuoteController::class);
    Route::resource('stats', AdminStatController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::get('/social', [\App\Http\Controllers\Admin\SocialController::class, 'edit'])
        ->name('social.edit');
    Route::get('/about', [AdminAboutController::class, 'edit'])
        ->name('about.edit');
    Route::put('/social', [\App\Http\Controllers\Admin\SocialController::class, 'update'])
        ->name('social.update');
    Route::resource('teams', TeamController::class);
    Route::put('/about', [AdminAboutController::class, 'update'])->name('about.update');
    Route::resource('categories', CategoryController::class);
    Route::resource('banners', BannerController::class);
    Route::get('/video', [\App\Http\Controllers\Admin\YoutubeVideoController::class, 'edit'])
        ->name('video.edit');
    Route::put('/video', [\App\Http\Controllers\Admin\YoutubeVideoController::class, 'update'])
        ->name('video.update');
});
// Groupe referencer
Route::prefix('referencer')
    ->middleware(['auth', 'role:referencer'])
    ->group(function () {
        Route::get('/dashboard', fn() => view('referencer.dashboard'))->name('referencer.dashboard');
    });
// Groupe advisor
Route::prefix('advisor')
    ->middleware(['auth', 'role:advisor'])
    ->group(function () {
        Route::get('/dashboard', fn() => view('advisor.dashboard'))->name('advisor.dashboard');
    });
// Tests middleware
Route::get('/test-role', fn() => "Middleware works!")
    ->middleware(['auth', 'role:admin'])
    ->name('test-role');
Route::get('/test-middleware', fn() => "Middleware works!")
    ->middleware(['auth', 'role:admin'])
    ->name('test-middleware');

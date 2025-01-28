<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LandingPageSettingController;
use App\Http\Controllers\MangaementAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

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
//landing page
Route::get('/', [LandingPageController::class, 'index'])->name('index');
Route::prefix('/blog')->group(function () {
    Route::get('/', [LandingPageController::class, 'blog'])->name('blog');
    Route::get('/{slug}', [LandingPageController::class, 'blogDetail'])->name('blog-detail');
});

// send mail
Route::post('/send-mail', [LandingPageController::class, 'sendMail'])->name('send-mail');

//auth routes
Route::get('/login', function () {
    return view('auth.sign-in');
})->middleware('guest')->name('login');
Route::controller(AuthController::class)->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest')->name('post-login');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

//dashboard
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::prefix('/manage-admin')->group(function () {
            Route::get('/', [MangaementAdminController::class, 'index'])->name('management-admin.index');
            Route::get('/create', [MangaementAdminController::class, 'create'])->name('management-admin.create');
            Route::post('/store', [MangaementAdminController::class, 'store'])->name('management-admin.store');
            Route::get('/edit/{id}', [MangaementAdminController::class, 'edit'])->name('management-admin.edit');
            Route::patch('/update/{id}', [MangaementAdminController::class, 'update'])->name('management-admin.update');
            Route::delete('/delete/{id}', [MangaementAdminController::class, 'destroy'])->name('management-admin.delete');
            Route::patch('/update-status/{id}', [MangaementAdminController::class, 'updateStatus'])->name('management-admin.update-status');
        });

        Route::prefix('landing-page-settings')->group(function () {
            Route::get('/', [LandingPageSettingController::class, 'index'])->name('landing-page-settings.index');
            Route::patch('/update-home', [LandingPageSettingController::class, 'updateHome'])->name('landing-page-settings.update-home');
            Route::get('/about', [LandingPageSettingController::class, 'aboutUs'])->name('landing-page-settings.about-us');
            Route::patch('/update-about', [LandingPageSettingController::class, 'updateAboutUs'])->name('landing-page-settings.update-about');

            //product
            Route::get('/product', [ProductController::class, 'index'])->name('landing-page-settings.product.index');
            Route::post('/product/store', [ProductController::class, 'store'])->name('landing-page-settings.product.store');
            Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('landing-page-settings.product.edit');
            Route::patch('/product/update/{id}', [ProductController::class, 'update'])->name('landing-page-settings.product.update');
            Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('landing-page-settings.product.delete');

            //team
            Route::get('/teams', [TeamController::class, 'index'])->name('landing-page-settings.team.index');
            Route::post('/team/store', [TeamController::class, 'store'])->name('landing-page-settings.team.store');
            Route::get('/team/edit/{id}', [TeamController::class, 'edit'])->name('landing-page-settings.team.edit');
            Route::patch('/team/update/{id}', [TeamController::class, 'update'])->name('landing-page-settings.team.update');
            Route::delete('/team/delete/{id}', [TeamController::class, 'destroy'])->name('landing-page-settings.team.delete');

            //contact
            Route::get('/contact', [ContactController::class, 'index'])->name('landing-page-settings.contact.index');
            Route::post('/contact/store', [ContactController::class, 'store'])->name('landing-page-settings.contact.store');
            Route::get('/contact/edit/{id}', [ContactController::class, 'edit'])->name('landing-page-settings.contact.edit');
            Route::patch('/contact/update/{id}', [ContactController::class, 'update'])->name('landing-page-settings.contact.update');
            Route::delete('/contact/delete/{id}', [ContactController::class, 'destroy'])->name('landing-page-settings.contact.delete');

            //gallery
            Route::get('/gallery', [GalleryController::class, 'index'])->name('landing-page-settings.gallery.index');
            Route::post('/gallery/store', [GalleryController::class, 'store'])->name('landing-page-settings.gallery.store');
            Route::get('/gallery/edit/{id}', [GalleryController::class, 'edit'])->name('landing-page-settings.gallery.edit');
            Route::patch('/gallery/update/{id}', [GalleryController::class, 'update'])->name('landing-page-settings.gallery.update');
            Route::patch('/gallery/update-status/{id}', [GalleryController::class, 'updateStatus'])->name('landing-page-settings.gallery.update-status');
            Route::delete('/gallery/delete/{id}', [GalleryController::class, 'destroy'])->name('landing-page-settings.gallery.delete');
        });

        //blog categories
        Route::prefix('blog-categories')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->name('blog-categories.index');
            Route::post('/store', [BlogCategoryController::class, 'store'])->name('blog-categories.store');
            Route::get('/edit/{id}', [BlogCategoryController::class, 'edit'])->name('blog-categories.edit');
            Route::patch('/update/{id}', [BlogCategoryController::class, 'update'])->name('blog-categories.update');
            Route::delete('/delete/{id}', [BlogCategoryController::class, 'destroy'])->name('blog-categories.delete');
        });

        //blogs
        Route::prefix('blogs')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
            Route::get('/create', [BlogController::class, 'create'])->name('blogs.create');
            Route::post('/store', [BlogController::class, 'store'])->name('blogs.store');
            Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('blogs.edit');
            Route::patch('/update/{id}', [BlogController::class, 'update'])->name('blogs.update');
            Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('blogs.delete');
            Route::post('/upload-image', [BlogController::class, 'uploadImageContentBlogs'])->name('blogs.upload-image');
            Route::delete('/delete-image', [BlogController::class, 'deleteImageBlogs'])->name('blogs.delete-image');
        });
    });
});

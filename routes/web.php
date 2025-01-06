<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LandingPageSettingController;
use App\Http\Controllers\MangaementAdminController;
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
        Route::get('/', function () {
            return view('dashboard.views.index');
        })->name('dashboard');
        Route::prefix('/manage-admin')->group(function () {
            Route::get('/', [MangaementAdminController::class, 'index'])->name('management-admin.index');
            Route::get('/create', [MangaementAdminController::class, 'create'])->name('management-admin.create');
            Route::post('/store', [MangaementAdminController::class, 'store'])->name('management-admin.store');
            Route::get('/edit/{id}', [MangaementAdminController::class, 'edit'])->name('management-admin.edit');
            Route::patch('/update/{id}', [MangaementAdminController::class, 'update'])->name('management-admin.update');
            Route::delete('/delete/{id}', [MangaementAdminController::class, 'destroy'])->name('management-admin.delete');
        });

        Route::prefix('landing-page-settings')->group(function () {
            Route::get('/', [LandingPageSettingController::class, 'index'])->name('landing-page-settings.index');
            Route::patch('/update-home', [LandingPageSettingController::class, 'updateHome'])->name('landing-page-settings.update-home');
        });
    });
});

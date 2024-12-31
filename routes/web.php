<?php

use App\Http\Controllers\AuthController;
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

Route::get('/', function () {
    return view('landing-pages.view.index');
});
// Route::get('/login', function () {
//     return view('auth.sign-in');
// })->middleware('guest')->name('login');
Route::get('/login', function () {
    return view('auth.sign-in');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest')->name('post-login');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');
});

Route::get('/dashboard', function () {
    return view('dashboard.views.index');
});

require __DIR__ . '/auth.php';

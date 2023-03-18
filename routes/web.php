<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [WebController::class, 'index'])->name('homepage');
Route::get('/post/{slug}', [WebController::class, 'show'])->name('view-post');
Route::get('/daily-update-email', [WebController::class, 'dailyUpdateEmail'])->name('daily-update-email');

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    Route::get('/add-post', [PostController::class, 'index'])->name('add-post');
    Route::get('/edit-post/{id}', [PostController::class, 'edit'])->name('edit-post');
    Route::post('/submit-post', [PostController::class, 'store'])->name('submit-post');
    Route::post('/publish-post', [PostController::class, 'update'])->name('publish-post');
    Route::post('/delete-post', [PostController::class, 'destroy'])->name('delete-post');
});

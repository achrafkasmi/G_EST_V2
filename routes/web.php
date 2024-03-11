<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadManager;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



 Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dash', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::post('/upload', [UploadManager::class, 'uploadPost'])->name('upload.post');
    Route::get('/messtages', function () {return view('messtages');})->name('messtages');
    Route::get('/', function () {return view('Dashboards.dashteacher');})->name('dashteacher');

    Route::get('/dashteacher', [App\Http\Controllers\DashboardController::class, 'dashteacher'])->name('dashteacher');

    Route::get('/gridetudiant', function () {return view('gridetudiant');})->name('gridetudiant');
    Route::post('/addUser', [App\Http\Controllers\HomeController::class, 'addUser'])->name('ADD-USER');
});

Route::get('/addnotice', function () {return view('addnotice');})->name('gridetudiant');








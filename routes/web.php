<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadManager;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AvisController;
use App\Models\Avis;


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


//Auth::routes();
 Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/', [App\Http\Controllers\HomeController::class, 'dashHome'])->name('HOME-DAWH');

    Route::get('/dash', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/upload', [UploadManager::class, 'uploadPost'])->name('upload.post');

    Route::get('/messtages', [App\Http\Controllers\DashboardController::class, 'myIntern'])->name('messtages');

    Route::get('/dashteacher', [App\Http\Controllers\DashboardController::class, 'dashteacher'])->name('dashteacher');


    // TO DO 

    Route::get('/gridetudiant', function () {return view('gridetudiant');})->name('gridetudiant');
});


Route::post('/post/logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('AUTH-LOGOUT');

Route::post('/post/connexion', [App\Http\Controllers\AuthenticationController::class, 'postLogin'])->name('POST-CONNEXION');

Route::get('/connexion', [App\Http\Controllers\AuthenticationController::class, 'login'])->name('login');

Route::get('/addUser', [App\Http\Controllers\AuthenticationController::class, 'addUserForm'])->name('ADD-USER-FORM');

Route::post('/addUser', [App\Http\Controllers\AuthenticationController::class, 'postUser'])->name('POST-USER-FORM');

Route::get('/addnotice', function () {return view('addnotice');})->name('gridetudiant');

Route::post('/import/users', [App\Http\Controllers\AuthenticationController::class, 'importUsers'])->name('import.excel');

Route::get('/student-recommendation/{id}',[App\Http\Controllers\libraryController::class, 'recommand'])->name('student.recomandation');

Route::post('/add/comment',[App\Http\Controllers\NotificatioController::class, 'addComment'])->name('ADD-RAPPORT-COMMENT');





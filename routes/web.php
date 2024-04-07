<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadManager;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AvisController;
use App\Models\Avis;
use App\Http\Controllers\libraryController;
use App\Models\Library;
use App\Http\Controllers\DocumentController;


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


//Auth::routes();
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('HOME-DAWH');

    Route::get('/dash', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/upload', [UploadManager::class, 'uploadPost'])->name('upload.post');

    Route::get('/messtages', [App\Http\Controllers\DashboardController::class, 'myIntern'])->name('messtages');

    //Route::get('/dashteacher', [App\Http\Controllers\DashboardController::class, 'dashteacher'])->name('dashteacher');

    Route::get('/addUser', [App\Http\Controllers\AuthenticationController::class, 'addUserForm'])->name('ADD-USER-FORM');

    Route::post('/addUser', [App\Http\Controllers\AuthenticationController::class, 'postUser'])->name('POST-USER-FORM');

    Route::get('/gridetudiant', function () {
        return view('gridetudiant');
    })->name('gridetudiant');

    Route::get('/addnotice', function () {return view('addnotice');})->name('gridetudiant');

    Route::post('/import/users', [App\Http\Controllers\AuthenticationController::class, 'importUsers'])->name('import.excel');

    Route::get('/student-recommendation/{id}', [App\Http\Controllers\libraryController::class, 'recommand'])->name('student.recomandation');

    Route::get('/student-validation/{id}', [App\Http\Controllers\libraryController::class, 'validationstage'])->name('student.validation');

    Route::get('/student-unvalidation/{id}', [App\Http\Controllers\libraryController::class, 'unvalidatestage'])->name('student.unvalidation');

    Route::post('/add/comment', [App\Http\Controllers\NotificatioController::class, 'addComment'])->name('ADD-RAPPORT-COMMENT');

    Route::get('/gestionstage', function () {
        return view('gestionstage');
    })->name('gestionstage');

    Route::get('/stages', [App\Http\Controllers\libraryController::class, 'index'])->name('all.stages');






    Route::get('/library', [App\Http\Controllers\libraryController::class, 'fetchlibrary'])->name('fetch.library');





    Route::get('/managedocuments', [App\Http\Controllers\DocumentController::class, 'managedocuments'])->name('DC');
    Route::post('/managedocuments', [DocumentController::class, 'store'])->name('document.post');


    Route::get('/documents', [DocumentController::class, 'showDocuments'])->name('documents');
});



Route::post('/post/logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('AUTH-LOGOUT');

Route::post('/post/connexion', [App\Http\Controllers\AuthenticationController::class, 'postLogin'])->name('POST-CONNEXION');

Route::get('/connexion', [App\Http\Controllers\AuthenticationController::class, 'login'])->name('login');

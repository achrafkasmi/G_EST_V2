<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadManager;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\Diplome;
use App\Models\Avis;
use App\Http\Controllers\libraryController;
use App\Models\Library;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\ElementPedagogiqueController;
use App\Http\Controllers\PersonnelElementPedagoguiqueController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorReportMail;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetraitController;







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

    Route::get('/dashteacher', [App\Http\Controllers\DashboardController::class, 'dashteacher'])->name('dashteacher');

    Route::get('/addUser', [App\Http\Controllers\AuthenticationController::class, 'addUserForm'])->name('ADD-USER-FORM');

    Route::post('/addUser', [App\Http\Controllers\AuthenticationController::class, 'postUser'])->name('POST-USER-FORM');

    Route::get('/gridetudiant', function () {
        return view('gridetudiant');
    })->name('gridetudiant');

    Route::get('/addnotice', function () {
        return view('addnotice');
    })->name('gridetudiant');

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

    Route::get('/approve-dossier/{dossier_id}', [App\Http\Controllers\libraryController::class, 'approveDossier'])->name('approve-dossier');

    Route::get('/upload/{id}/edit', [UploadManager::class, 'edit'])->name('upload.edit'); //
    Route::get('/upload/edit/{stage}', [UploadManager::class, 'edit'])->name('upload.edit'); //


    Route::get('/modules', function () {
        $active_tab = 'modules';
        return view('modules', compact('active_tab'));
    })->name('modules');

    Route::post('/diplomes', [Diplome::class, 'store'])->name('diplomes.store');

    Route::get('/diplomes', [App\Http\Controllers\Diplome::class, 'index'])->name('diplomes.index');

    Route::post('/mark-notification-as-seen/{notification}', [App\Http\Controllers\NotificatioController::class, 'markAsSeen'])->name('mark-notification-as-seen');



    Route::get('/gestionelements/{module_id}', [ElementController::class, 'index'])->name('gestionelements');
    Route::post('/element', [ElementController::class, 'store'])->name('element.store');
    Route::get('/elementspedago/{id}/{etape_id}', [ElementPedagogiqueController::class, 'fetchData'])->name('elementspedago');


    Route::get('/voiceform/{id}', [App\Http\Controllers\NotificatioController::class, 'voiceFormUrl'])->name('VOICE-FORM_URL');

    Route::post('/store-etape-diplome', [Diplome::class, 'storeEtapeDiplome'])->name('store-etape-diplome');
    








    Route::post('/elementspedago/{id}/{etape_id}', [ElementPedagogiqueController::class, 'store'])->name('store-module-etape');
    
    Route::post('/store-teacher-element/{id}/{etape_id}', [PersonnelElementPedagoguiqueController::class, 'storeTeacherElement'])->name('storeTeacherElement');

    Route::get('/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('attendance.form');

    Route::post('/generate-qr-code', [AttendanceController::class, 'generateQrCode'])->name('generate.qr.code');

    Route::get('/mark-attendance', [AttendanceController::class, 'markAttendance'])->name('mark.attendance');

    Route::get('/manuallibrary', function () {
        $active_tab = 'manuallibrary';
        return view('manuallibrary', compact('active_tab'));
    })->name('manuallibrary');

    Route::post('/dossier-stage/manualstore', [UploadManager::class, 'manualstore'])->name('dossier-stage.manualstore');

    Route::get('/store-scanned-attendance', [AttendanceController::class, 'storeScannedAttendance'])->name('storeScannedAttendance');

    Route::post('/elementspedago/{id}/{etape_id}/upload', [ElementPedagogiqueController::class, 'storeByExcel'])->name('storeByExcel');

    /* email errors*/
    Route::get('/trigger-error', function () {
        throw new Exception('This is a test exception!');
    });
    Route::get('/test-email', function () {
        try {
            Mail::to('aeroengine02@gmail.com')->send(new ErrorReportMail(new Exception('Test exception')));
            return 'Test email sent!';
        } catch (Exception $e) {
            return 'Failed to send email: ' . $e->getMessage();
        }
    });
});

Route::post('/post/logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('AUTH-LOGOUT');

Route::post('/post/connexion', [App\Http\Controllers\AuthenticationController::class, 'postLogin'])->name('POST-CONNEXION');

Route::get('/connexion', [App\Http\Controllers\AuthenticationController::class, 'login'])->name('login');



Route::post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture'])->name('upload.profile.picture');

Route::get('/retrait/{id_etu}', [RetraitController::class, 'index'])->name('retrait');

Route::post('/storeretrait', [RetraitController::class, 'storeretrait'])->name('storeretrait');

Route::get('/activate/{id_etu}', [RetraitController::class, 'activate'])->name('activate');


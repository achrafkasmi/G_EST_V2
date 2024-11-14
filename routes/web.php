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
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ErrorReportMail;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RetraitController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TerminalController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


//Auth::routes();
Route::middleware(['auth'])->group(function () {

    Route::middleware(['web'])->group(function () {

        Route::get('/attendance', [AttendanceController::class, 'showAttendanceForm'])->name('attendance.form');

        Route::post('/generate-qr-code', [AttendanceController::class, 'generateQrCode'])->name('generate.qr.code');

        Route::get('/scan-qr-code', [AttendanceController::class, 'handleQrCodeScan'])->name('scan.qr.code');

        Route::get('/attendance-success', function () {
            $active_tab = 'dash';
            return view('attendancesuccess', compact('active_tab'));
        })->name('attendance.success');

        Route::get('/attendance-failure', function () {
            $active_tab = 'dash';
            return view('attendancefailure', compact('active_tab'));
        })->name('attendance.failure');

        Route::get('/mark-attendance', [AttendanceController::class, 'markAttendance'])->name('mark.attendance');

        Route::get('/attendance/scanned-count', [AttendanceController::class, 'getScannedCount'])->name('attendance.getScannedCount');


        Route::get('/scanned-list', [AttendanceController::class, 'getScannedList'])->name('scanned.list');

        Route::get('/attendance/manual-entry', [AttendanceController::class, 'showManualEntryForm'])->name('attendance.manual.entry.form');

        Route::post('/attendance/manual-entry', [AttendanceController::class, 'handleManualEntry'])->name('attendance.manual.entry');

        Route::get('/attendance/scanned-list', [AttendanceController::class, 'getScannedList'])->name('attendance.getScannedList');

        Route::post('/attendance/mark-as-present/{id}', [AttendanceController::class, 'markAsPresent'])->name('attendance.markAsPresent');

        Route::get('/student-attendance-stats', [AttendanceController::class, 'studentAttendanceStats'])->name('student.attendance.stats');
    });



    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('HOME-DAWH');

    Route::get('/dash', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::post('/upload', [UploadManager::class, 'uploadPost'])->name('upload.post');

    Route::get('/messtages', [App\Http\Controllers\DashboardController::class, 'myIntern'])->name('messtages');

    /*Route::get('/dashteacher', [App\Http\Controllers\DashboardController::class, 'dashteacher'])->name('dashteacher');*/

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

    Route::get('/documentsdash', [DocumentController::class, 'index'])->name('documents.index');

    /*Route::get('/documentsettings', [DocumentController::class, 'documentsettingsindex'])->name('documentsettings.index');*/

    Route::get('/documentsettings', [DocumentController::class, 'griddocindex'])->name('documentsettings.index');

    Route::get('/documents', [DocumentController::class, 'showDocuments'])->name('documents');

    Route::get('/approve-dossier/{dossier_id}', [App\Http\Controllers\libraryController::class, 'approveDossier'])->name('approve-dossier');

    Route::get('/upload/{id}/edit', [UploadManager::class, 'edit'])->name('upload.edit');

    Route::get('/upload/edit/{stage}', [UploadManager::class, 'edit'])->name('upload.edit');

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
    

    Route::post('/documents/archive/{document}', [DocumentController::class, 'toggleArchive'])->name('documents.archive');

    Route::delete('/documents/delete/{document}', [DocumentController::class, 'deleteDocument'])->name('documents.delete');

    Route::get('/attendance/stats-form', [AttendanceController::class, 'getStatsForm'])->name('attendance.statsForm');

    Route::post('/attendance/generate-stats-pdf', [AttendanceController::class, 'generateStatsPdf'])->name('Generate.statsPdf');

    Route::get('/manuallibrary', function () {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
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
            Mail::to('k.ashraf.usms@gmail.com')->send(new ErrorReportMail(new Exception('Test exception')));
            return 'Test email sent!';
        } catch (Exception $e) {
            return 'Failed to send email: ' . $e->getMessage();
        }
    });

    Route::post('/upload-profile-picture', [ProfileController::class, 'uploadProfilePicture'])->name('upload.profile.picture');

    Route::get('/retrait/{id_etu}', [RetraitController::class, 'index'])->name('retrait');

    Route::post('/storeretrait', [RetraitController::class, 'storeretrait'])->name('storeretrait');

    Route::get('/activate/{id_etu}', [RetraitController::class, 'activate'])->name('activate');

    Route::get('/storelaureat/{id_etu}', [RetraitController::class, 'storelaureat'])->name('storelaureat');

    Route::post('/storelaureat', [RetraitController::class, 'storelaureatPost'])->name('storelaureat.post');

    Route::get('/usercard/{id_etu}', [ProfileController::class, 'usercard'])->name('usercard');

    Route::get('/studentmanage', [StudentController::class, 'index'])->name('index.studentmanage');

    Route::get('/terminal', [TerminalController::class, 'index'])->name('terminal.index');

    Route::post('/terminal/execute', [TerminalController::class, 'execute'])->name('terminal.execute');

    Route::get('/logs', [LogController::class, 'index'])->name('logs');

    Route::get('user/{id_etu}/card', [ProfileController::class, 'usercard'])->name('usercard');

    Route::get('/test/page', function () {
        dd(phpinfo());
    });

    Route::get('/manualID', [AttendanceController::class, 'showinputBlade'])->name('scanner.blade');

    Route::get('/attendancedash', [AttendanceController::class, 'showattendancedashboard'])->name('attendance.dash.blade');

    Route::get('/student-selection', [StudentController::class, 'showSelectionForm'])->name('student.selection');
    Route::post('/generate-pdf', [StudentController::class, 'generatePDF'])->name('student.generatePDF');

    Route::post('/identify-absent-students', [AttendanceController::class, 'identifyAndStoreAbsentStudents'])->name('identify.absent.students');

    Route::post('/attendance/manual-entry', [AttendanceController::class, 'handleManualEntry'])->name('attendance.manual.entry');

    Route::get('/attendance/justify', [AttendanceController::class, 'indexOfJustification'])->name('attendance.justify');

    Route::post('/attendance/store-justification', [AttendanceController::class, 'storeJustification'])->name('attendance.storeJustification');

    Route::get('/attendance/admin-overview', [AttendanceController::class, 'AdminAttendanceStatsIndex'])->name('Admin.Attendance.Stats.Index');

    Route::get('/fetch-attendance-data', [AttendanceController::class, 'fetchAttendanceData'])->name('admin.fetchAttendanceData');

    Route::get('/fetch-attendance-data', [AttendanceController::class, 'fetchAttendanceData'])->name('admin.fetchCurrentDateAttendanceStats');

    Route::get('/password/reset', [ResetPasswordController::class, 'index'])->name('password.reset.form');

    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

    Route::get('/get-student-count', [DashboardController::class, 'getStudentCount']);

    Route::get('/avatar-select', [StudentController::class, 'avatarSelectIndex'])->name('avatar.select');

    Route::post('/generate-pdff', [StudentController::class, 'generateAvatarPDF'])->name('document.generatePDF');
    
    Route::post('/attendance/clear-temp-scanned-students', [AttendanceController::class, 'clearTempScannedStudents'])->name('attendance.clearTempScannedStudents');

    // Route::post('/clear-expired-temp-scanned-students', [AttendanceController::class, 'clearExpiredTempScannedStudents'])->name('clearExpiredTempScannedStudents');

    Route::post('/baccalaureates/upload', [DocumentController::class, 'upload'])->name('baccalaureates.upload');
   
    Route::get('/dash-of-scan', [DocumentController::class, 'indexscannedbac'])->name('dash-of-scan');
});


Route::post('/post/logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('AUTH-LOGOUT');

Route::post('/post/connexion', [App\Http\Controllers\AuthenticationController::class, 'postLogin'])->name('POST-CONNEXION');

Route::get('/connexion', [App\Http\Controllers\AuthenticationController::class, 'login'])->name('login');

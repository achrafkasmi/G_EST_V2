<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Personnel;
use App\Models\Attendance;
use App\Models\Etudiant;
use App\Models\ElementPedagogique;
use App\Models\TempScannedStudent;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AttendanceController extends Controller
{
    public function showAttendanceForm()
    {
        if (!auth()->user()->hasRole('teacher')) {
            abort(403);
        }

        $active_tab = 'attendance';

        $locals = Local::pluck('nom_locaux', 'id');
        $personnels = Personnel::pluck('nom_personnel', 'id');
        $elementsPedago = ElementPedagogique::pluck('intitule_element', 'id');
        $annees = Etudiant::select('Annee')->distinct()->pluck('Annee');
        $filieres = Etudiant::select('FILIERE')->distinct()->pluck('FILIERE');
        $anneeUnis = Etudiant::select('annee_uni')->distinct()->pluck('annee_uni');

        return view('attendance', compact('active_tab', 'locals', 'personnels', 'elementsPedago', 'annees', 'filieres', 'anneeUnis'));
    }

    public function showinputBlade()
    {
        if (!auth()->user()->hasRole('student')) {
            abort(403);
        }
        $active_tab = 'attendance';
        return view('scannerQR', compact('active_tab'));
    }

    public function showattendancedashboard()
    {
        if (!auth()->user()->hasRole('student')) {
            abort(403);
        }
        $active_tab = 'attendance';
        return view('attendancedashboard', compact('active_tab'));
    }

    public function generateQrCode(Request $request)
    {
        if (!auth()->user()->hasRole('teacher')) {
            abort(403);
        }

        $active_tab = 'attendance';

        $validatedData = $request->validate([
            'id_local' => 'required|exists:t_locaux,id',
            'id_personnel' => 'required|exists:t_personnel,id',
            'id_element_pedago' => 'required|exists:t_modules_etape,id',
            'annee' => 'required|string',
            'filiere' => 'required|string',
            'annee_uni' => 'required|string',
            'periode_seance' => 'required|string',
        ]);

        // Generate a unique code
        $uniqueCode = Str::random(10);

        $url = route('scan.qr.code', [
            'id_local' => $validatedData['id_local'],
            'id_personnel' => $validatedData['id_personnel'],
            'id_element_pedago' => $validatedData['id_element_pedago'],
            'annee' => $validatedData['annee'],
            'filiere' => $validatedData['filiere'],
            'annee_uni' => $validatedData['annee_uni'],
            'periode_seance' => $validatedData['periode_seance'],
            'code' => $uniqueCode,
        ]);

        $qrCode = QrCode::format('png')->size(500)->generate($url);

        // Store data in session for later use
        Session::put('attendance_data', $validatedData);
        Session::put('unique_code', $uniqueCode);

        return view('attendance_qr_code', compact('qrCode', 'uniqueCode', 'active_tab'));
    }

    public function handleQrCodeScan(Request $request)
    {
        $active_tab = 'attendance';

        $attendanceData = $request->only(['id_local', 'id_personnel', 'id_element_pedago', 'annee', 'filiere', 'annee_uni', 'periode_seance']);

        $student = auth()->user()->etudiant;

        if (!$student) {
            return redirect()->route('attendance.failure')->with('message', 'Student does not exist');
        }

        $studentId = $student->id;

        $result = $this->markAttendance($attendanceData, $studentId);

        if ($result['success']) {
            return redirect()->route('attendance.success');
        } else {
            return redirect()->route('attendance.failure')->with('message', $result['message']);
        }
    }

    public function markAttendance($qrData, $studentId)
    {
        $studentExists = Etudiant::find($studentId);

        if (!$studentExists) {
            return ['success' => false, 'message' => 'Student does not exist'];
        }

        // Check if the student has already been scanned for the current session
        $alreadyScanned = TempScannedStudent::where('id_etu', $studentId)
            ->where('id_local', $qrData['id_local'])
            ->where('id_personnel', $qrData['id_personnel'])
            ->where('id_element_pedago', $qrData['id_element_pedago'])
            ->where('annee_uni', $qrData['annee_uni'])
            ->where('période_seance', $qrData['periode_seance'])
            ->exists();

        if ($alreadyScanned) {
            return ['success' => true, 'message' => 'Attendance already marked for this session'];
        }

        // Store scanned students' data temporarily
        TempScannedStudent::create([
            'id_etu' => $studentId,
            'id_local' => $qrData['id_local'],
            'id_personnel' => $qrData['id_personnel'],
            'id_element_pedago' => $qrData['id_element_pedago'],
            'annee_uni' => $qrData['annee_uni'],
            'période_seance' => $qrData['periode_seance'],
        ]);

        return ['success' => true, 'message' => 'Attendance marked successfully'];
    }

    public function identifyAndStoreAbsentStudents(Request $request)
    {
        $active_tab = 'attendance';

        // Retrieve attendance data from session
        $validatedData = Session::get('attendance_data');

        if (!$validatedData) {
            return redirect()->route('attendance.failure')->with('message', 'No attendance data found.');
        }

        // Retrieve all students based on the given criteria
        $students = Etudiant::where('Annee', $validatedData['annee'])
            ->where('FILIERE', $validatedData['filiere'])
            ->where('annee_uni', $validatedData['annee_uni'])
            ->get();

        // Retrieve IDs of students who scanned the QR code from the temporary table
        $scannedStudentIds = TempScannedStudent::where('id_local', $validatedData['id_local'])
            ->where('id_personnel', $validatedData['id_personnel'])
            ->where('id_element_pedago', $validatedData['id_element_pedago'])
            ->where('annee_uni', $validatedData['annee_uni'])
            ->where('période_seance', $validatedData['periode_seance'])
            ->pluck('id_etu')
            ->toArray();

        // Iterate over all students and mark those who didn't scan
        foreach ($students as $student) {
            $studentId = $student->id;
            if (!in_array($studentId, $scannedStudentIds)) {
                Attendance::create(
                    [
                        'id_etu' => $studentId,
                        'id_local' => $validatedData['id_local'],
                        'id_personnel' => $validatedData['id_personnel'],
                        'id_element_pedago' => $validatedData['id_element_pedago'],
                        'annee_uni' => $validatedData['annee_uni'],
                        'période_seance' => $validatedData['periode_seance'],
                        'is_absent' => true,
                        'Annee' => $validatedData['annee'],
                        'FILIERE' => $validatedData['filiere'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }

        // Clear scanned students from the temporary table
        TempScannedStudent::where('id_local', $validatedData['id_local'])
            ->where('id_personnel', $validatedData['id_personnel'])
            ->where('id_element_pedago', $validatedData['id_element_pedago'])
            ->where('annee_uni', $validatedData['annee_uni'])
            ->where('période_seance', $validatedData['periode_seance'])
            ->delete();

        return redirect()->route('attendance.success')->with('message', 'Absent students identified and stored.');
    }

    public function getScannedCount(Request $request)
    {
        $validatedData = Session::get('attendance_data');

        if (!$validatedData) {
            return response()->json(['count' => 0]);
        }

        // Retrieve the count of unique scanned students from the temporary table
        $scannedCount = TempScannedStudent::where('id_local', $validatedData['id_local'])
            ->where('id_personnel', $validatedData['id_personnel'])
            ->where('id_element_pedago', $validatedData['id_element_pedago'])
            ->where('annee_uni', $validatedData['annee_uni'])
            ->where('période_seance', $validatedData['période_seance'])
            ->count();

        return response()->json(['count' => $scannedCount]);
    }

    public function getScannedList()
    {
        $scannedStudents = TempScannedStudent::join('t_etudiant', 'temp_scanned_students.id_etu', '=', 't_etudiant.id')
            ->select('t_etudiant.nom_fr as last_name', 't_etudiant.prenom_fr as first_name')
            ->get();

        return response()->json(['students' => $scannedStudents]);
    }

    public function handleManualEntry(Request $request)
    {
    }
}

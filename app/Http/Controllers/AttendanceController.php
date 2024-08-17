<?php

namespace App\Http\Controllers;

use App\Models\{Local, Personnel, Attendance, Etudiant, ElementPedagogique, TempScannedStudent, TypeSeance};
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\{Auth, Session, DB};
use Carbon\Carbon;


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
        $typeSeances = TypeSeance::select('abreviation')->distinct()->pluck('abreviation');

        return view('attendance', compact('active_tab', 'locals', 'personnels', 'elementsPedago', 'annees', 'filieres', 'anneeUnis', 'typeSeances'));
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
            'type_seance' => 'required|string',
        ]);

        // Store session details in t_sessions table
        DB::table('t_sessions')->insert([
            'id_local' => $validatedData['id_local'],
            'id_personnel' => $validatedData['id_personnel'],
            'id_element_pedago' => $validatedData['id_element_pedago'],
            'annee' => $validatedData['annee'],
            'filiere' => $validatedData['filiere'],
            'annee_uni' => $validatedData['annee_uni'],
            'periode_seance' => $validatedData['periode_seance'],
            'type_seance' => $validatedData['type_seance'],
            'session_date' => now(), // Set the current date and time
        ]);

        $scannedStudentIds = TempScannedStudent::where('id_local', $validatedData['id_local'])
            ->where('id_personnel', $validatedData['id_personnel'])
            ->where('id_element_pedago', $validatedData['id_element_pedago'])
            ->where('annee_uni', $validatedData['annee_uni'])
            ->where('période_seance', $validatedData['periode_seance'])
            ->where('type_seance', $validatedData['type_seance'])
            ->pluck('id_etu')
            ->toArray();

        $url = route('scan.qr.code', array_merge($validatedData, [
            'type_seance' => $validatedData['type_seance'],
        ]));

        $qrCode = QrCode::format('png')->size(500)->generate($url);

        Session::put('attendance_data', $validatedData);

        $students = Etudiant::where('Annee', $validatedData['annee'])
            ->where('FILIERE', $validatedData['filiere'])
            ->where('annee_uni', $validatedData['annee_uni'])
            ->get();

        return view('attendance_qr_code', compact('qrCode', 'active_tab', 'students', 'scannedStudentIds'));
    }
    public function handleQrCodeScan(Request $request)
    {
        $active_tab = 'attendance';

        $attendanceData = $request->only(['id_local', 'id_personnel', 'id_element_pedago', 'annee', 'filiere', 'annee_uni', 'periode_seance', 'type_seance']);

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

        $alreadyScanned = TempScannedStudent::where('id_etu', $studentId)
            ->where('id_local', $qrData['id_local'])
            ->where('id_personnel', $qrData['id_personnel'])
            ->where('id_element_pedago', $qrData['id_element_pedago'])
            ->where('annee_uni', $qrData['annee_uni'])
            ->where('période_seance', $qrData['periode_seance'])
            ->where('type_seance', $qrData['type_seance'])
            ->exists();

        if ($alreadyScanned) {
            return ['success' => true, 'message' => 'Attendance already marked for this session'];
        } else {
            TempScannedStudent::create([
                'id_etu' => $studentId,
                'id_local' => $qrData['id_local'],
                'id_personnel' => $qrData['id_personnel'],
                'id_element_pedago' => $qrData['id_element_pedago'],
                'annee_uni' => $qrData['annee_uni'],
                'période_seance' => $qrData['periode_seance'],
                'type_seance' => $qrData['type_seance'],
            ]);

            return ['success' => true, 'message' => 'Attendance marked successfully'];
        }
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

        return redirect()->route('dashboard')->with(['message' => 'Absent students identified and stored.', 'success' => 'true']);
    }

    public function getScannedCount()
    {
        $count = TempScannedStudent::count();
        return response()->json(['count' => $count]);
    }

    public function getScannedList()
    {
        $students = Etudiant::all()->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->nom_fr . ' ' . $student->prenom_fr,
                'is_scanned' => TempScannedStudent::where('id_etu', $student->id)->exists(),
            ];
        });

        return response()->json(['students' => $students]);
    }

    public function markAsPresent($id)
    {
        $studentId = $id;

        // Check if the student is already marked as present
        $attendanceRecord = Attendance::where('id_etu', $studentId)
            ->where('id_local', Session::get('attendance_data')['id_local'])
            ->where('id_personnel', Session::get('attendance_data')['id_personnel'])
            ->where('id_element_pedago', Session::get('attendance_data')['id_element_pedago'])
            ->where('annee_uni', Session::get('attendance_data')['annee_uni'])
            ->where('période_seance', Session::get('attendance_data')['periode_seance'])
            ->exists();

        if ($attendanceRecord) {
            return response()->json(['success' => false, 'message' => 'Attendance already marked.']);
        } else {
            TempScannedStudent::create([
                'id_etu' => $studentId,
                'id_local' => Session::get('attendance_data')['id_local'],
                'id_personnel' => Session::get('attendance_data')['id_personnel'],
                'id_element_pedago' => Session::get('attendance_data')['id_element_pedago'],
                'annee_uni' => Session::get('attendance_data')['annee_uni'],
                'période_seance' => Session::get('attendance_data')['periode_seance'],
            ]);

            return response()->json(['success' => true]);
        }
    }


    public function studentAttendanceStats()
    {
        if (!auth()->user()->hasRole('student')) {
            abort(403);
        }

        $active_tab = 'attendance';
        $student = auth()->user()->etudiant;
        $studentId = $student->id;

        $studentYear = $student->Annee;
        $studentFiliere = $student->FILIERE;

        $totalSessions = \DB::table('t_sessions')
            ->where('annee', $studentYear)
            ->where('filiere', $studentFiliere)
            ->where('annee_uni', $student->annee_uni)
            ->count();

        $missedSessions = \DB::table('t_attendance')
            ->where('id_etu', $studentId)
            ->where('Annee', $studentYear)
            ->where('FILIERE', $studentFiliere)
            ->where('annee_uni', $student->annee_uni)
            ->where('is_absent', 1)
            ->count();

        $attendancePercentage = $totalSessions > 0 ?
            round((($totalSessions - $missedSessions) / $totalSessions) * 100, 2) : 0;

        $attendanceByModule = \DB::table('t_attendance')
            ->join('t_modules_etape', 't_modules_etape.id', '=', 't_attendance.id_element_pedago')
            ->where('t_attendance.id_etu', $studentId)
            ->where('t_attendance.Annee', $studentYear)
            ->where('t_attendance.FILIERE', $studentFiliere)
            ->where('t_attendance.annee_uni', $student->annee_uni)
            ->select(
                't_modules_etape.intitule_element',
                \DB::raw('COUNT(*) as total_sessions'),
                \DB::raw('SUM(is_absent) as missed_sessions')
            )
            ->groupBy('t_modules_etape.intitule_element')
            ->get();

        $attendanceTrend = \DB::table('t_attendance')
            ->where('id_etu', $studentId)
            ->where('Annee', $studentYear)
            ->where('FILIERE', $studentFiliere)
            ->where('annee_uni', $student->annee_uni)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($attendance) {
                return [
                    'date' => Carbon::parse($attendance->created_at)->format('Y-m-d'),
                    'status' => $attendance->is_absent ? 'Absent' : 'Present'
                ];
            });

        return view('EtudiantStats', compact('totalSessions', 'missedSessions', 'attendancePercentage', 'attendanceByModule', 'attendanceTrend', 'active_tab'));
    }

    
    public function studentAttendanceRate()
    {
        if (!auth()->user()->hasRole('student')) {
            abort(403);
        }
    
        $student = auth()->user()->etudiant;
        $studentId = $student->id;
    
        $studentYear = $student->Annee;
        $studentFiliere = $student->FILIERE;
    
        $totalSessions = \DB::table('t_sessions')
            ->where('annee', $studentYear)
            ->where('filiere', $studentFiliere)
            ->where('annee_uni', $student->annee_uni)
            ->count();
    
        $missedSessions = \DB::table('t_attendance')
            ->where('id_etu', $studentId)
            ->where('Annee', $studentYear)
            ->where('FILIERE', $studentFiliere)
            ->where('annee_uni', $student->annee_uni)
            ->where('is_absent', 1)
            ->count();
    
        $attendancePercentage = $totalSessions > 0 ?
            round((($totalSessions - $missedSessions) / $totalSessions) * 100, 2) : 0;
    
        return [
            'totalSessions' => $totalSessions,
            'missedSessions' => $missedSessions,
            'attendancePercentage' => $attendancePercentage,
        ];
    }
    
    
}
<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Personnel;
use App\Models\Attendance;
use App\Models\Etudiant;
use App\Models\ElementPedagogique;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    public function showAttendanceForm()
    {
        $active_tab = 'attendance';

        $locals = Local::pluck('nom_locaux', 'id');
        $personnels = Personnel::pluck('nom_personnel', 'id');
        $elementsPedago = ElementPedagogique::pluck('intitule_element', 'id');

        return view('attendance', compact('active_tab', 'locals', 'personnels', 'elementsPedago'));
    }

    public function showscannerBlade()
    {
        $active_tab = 'attendance';
        return view('scannerQR', compact('active_tab'));
    }

    public function showattendancedashboard()
    {
        $active_tab = 'attendance';
        return view('attendancedashboard', compact('active_tab'));
    }

    public function generateQrCode(Request $request)
    {
        $active_tab = 'attendance';

        // Validate the request data
        $validatedData = $request->validate([
            'id_local' => 'required|exists:t_locaux,id',
            'id_personnel' => 'required|exists:t_personnel,id',
            'id_element_pedago' => 'required|exists:t_modules_etape,id',
            'annee_uni' => 'required|string',
            'heure_debut_seance' => 'required',
            'heure_fin_seance' => 'required',
        ]);

        // Generate the QR code URL with attendance data
        $url = route('scan.qr.code', [
            'id_local' => $validatedData['id_local'],
            'id_personnel' => $validatedData['id_personnel'],
            'id_element_pedago' => $validatedData['id_element_pedago'],
            'annee_uni' => $validatedData['annee_uni'],
            'heure_debut_seance' => $validatedData['heure_debut_seance'],
            'heure_fin_seance' => $validatedData['heure_fin_seance'],
        ]);

        // Generate the QR code
        $qrCode = QrCode::format('png')->size(300)->generate($url);

        // Return the QR code image directly
        return response($qrCode)->header('Content-type', 'image/png');
    }

    public function handleQrCodeScan(Request $request)
    {
        $active_tab = 'attendance';
    
        // Extract attendance data from the URL query parameters
        $attendanceData = $request->only(['id_local', 'id_personnel', 'id_element_pedago', 'annee_uni', 'heure_debut_seance', 'heure_fin_seance']);
    
        // Check if the user is logged in
        if (!auth()->check()) {
            // Store the attendance data in the session and redirect to login
            session(['attendance_data' => $attendanceData]);
            return redirect()->route('login');
        }
    
        // Get the logged-in student's ID through the relationship
        $student = auth()->user()->etudiant;
        
        if (!$student) {
            return redirect()->route('attendance.failure')->with('message', 'Student does not exist');
        }
    
        $studentId = $student->id;
    
        // If logged in, mark attendance and redirect with a success message
        $result = $this->markAttendance($attendanceData, $studentId);
    
        if ($result['success']) {
            return redirect()->route('attendance.success');
        } else {
            return redirect()->route('attendance.failure')->with('message', $result['message']);
        }
    }
    
    public function markAttendance($qrData, $studentId)
    {
        // Check if the student exists using the Etudiant model
        $studentExists = Etudiant::find($studentId);
        
        if (!$studentExists) {
            return ['success' => false, 'message' => 'Student does not exist'];
        }
    
        // Mark the student as present in the attendance table
        Attendance::updateOrCreate(
            [
                'id_etu' => $studentId,
                'id_local' => $qrData['id_local'],
                'id_personnel' => $qrData['id_personnel'],
                'id_element_pedago' => $qrData['id_element_pedago'],
                'annee_uni' => $qrData['annee_uni'],
                'heure_debut_séance' => $qrData['heure_debut_seance'],
                'heure_fin_séance' => $qrData['heure_fin_seance'],
            ],
            ['is_present' => true]
        );
    
        // Return success response
        return ['success' => true, 'message' => 'Attendance marked successfully'];
    }
    

    public function storeScannedAttendance(Request $request)
    {
        $active_tab = 'attendance';

        // Validate the QR data
        $request->validate([
            'qr_data' => 'required|string',
        ]);

        $qrData = json_decode($request->input('qr_data'), true);

        // Mark the attendance based on the QR data
        try {
            Attendance::create([
                'id_local' => $qrData['id_local'],
                'id_personnel' => $qrData['id_personnel'],
                'id_element_pedago' => $qrData['id_element_pedago'],
                'annee_uni' => $qrData['annee_uni'],
                'heure_debut_séance' => $qrData['heure_debut_seance'],
                'heure_fin_séance' => $qrData['heure_fin_seance'],
            ]);

            return response()->json(['success' => true, 'message' => 'Attendance recorded successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to record attendance.']);
        }
    }
}

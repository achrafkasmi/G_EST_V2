<?php

namespace App\Http\Controllers;

use App\Models\Local;
use App\Models\Personnel;
use App\Models\Attendance;
use App\Models\ElementPedagogique;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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


    public function generateQrCode(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'id_local' => 'required|exists:t_locaux,id',
            'id_personnel' => 'required|exists:t_personnel,id',
            'id_element_pedago' => 'required|exists:t_modules_etape,id',
            'annee_uni' => 'required|string',
            'heure_debut_seance' => 'required',
            'heure_fin_seance' => 'required',
        ]);

        // Generate the QR code data
        $qrData = json_encode($validatedData);

        // Generate the QR code
        $qrCode = QrCode::format('png')->size(300)->generate($qrData);

        // Return the QR code image directly
        return response($qrCode)->header('Content-type', 'image/png');
    }

    public function markAttendance(Request $request)
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            return response()->json(['message' => 'Please log in to mark your attendance']);
        }

        // Get the logged-in user's ID
        $studentId = auth()->user()->id;

        // Extract data from the request
        $qrData = $request->input('qr_data');
        $macAddress = $request->input('mac_address'); // Ensure you send this from the client side

        // Check if the same MAC address has already been used for the same QR code data
        $existingAttendance = Attendance::where('id_local', $qrData['id_local'])
            ->where('id_personnel', $qrData['id_personnel'])
            ->where('id_element_pedago', $qrData['id_element_pedago'])
            ->where('annee_uni', $qrData['annee_uni'])
            ->where('heure_debut_séance', $qrData['heure_debut_seance'])
            ->where('heure_fin_séance', $qrData['heure_fin_seance'])
            ->where('mac_address', $macAddress)
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'This device has already been used to mark attendance for this session.']);
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
            ['is_present' => true, 'mac_address' => $macAddress]
        );

        // Return success response
        return response()->json(['message' => 'Attendance marked successfully']);
    }




    public function storeScannedAttendance(Request $request)
{
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retrait;
use App\Models\Etudiant;
use App\Models\Diplome;
use App\Models\Laureat;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\DB;
use PDF;
use Mpdf\Mpdf;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;



class StudentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'stumana';
        return view('studentmanagement', compact('active_tab'));
    }
    public function showSelectionForm()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'stumana';
        $annees = Etudiant::select('Annee')->distinct()->get();
        $filieres = Etudiant::select('FILIERE')->distinct()->get();
        return view('student-selection', compact('annees', 'filieres', 'active_tab'));
    }

    public function generatePDF(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'stumana';
        $validated = $request->validate([
            'annee' => 'required',
            'filiere' => 'required',
            'annee_uni' => 'required'
        ]);
        $columns = $request->input('columns', []);
        $students = Etudiant::where('Annee', $validated['annee'])
            ->where('FILIERE', $validated['filiere'])
            ->where('is_active', '1')
            ->where('annee_uni', $validated['annee_uni'])
            ->get();

        $pdf = PDF::loadView('student-list', compact('students', 'active_tab', 'columns'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('student-list.pdf');
    }

    public function avatarSelectIndex()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $active_tab = 'stumana';
        $annees = Etudiant::select('Annee')->distinct()->get();
        $filieres = Etudiant::select('FILIERE')->distinct()->get();
        $apogees = Etudiant::select('Apogee')->distinct()->get();
        $annee_unis = Etudiant::select('annee_uni')->distinct()->get();

        return view('avatarSelect', compact('annees', 'filieres', 'apogees', 'annee_unis', 'active_tab'));
    }




    public function generateAvatarPDF(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'filiere' => 'required|string',
            'annee' => 'required|string',
            'annee_uni' => 'required|string',
        ]);

        $students = Etudiant::where('FILIERE', $request->filiere)
            ->where('annee', $request->annee)
            ->where('annee_uni', $request->annee_uni)
            ->with('user')
            ->get();

        // Create a new instance of mPDF
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => [53.98, 85.6], // Width x Height in mm
            'orientation' => 'L', // Landscape orientation
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
        ]);

        // Set document information
        $mpdf->SetTitle('Student University Cards');

        // Loop through each student and generate a page
        foreach ($students as $student) {
            // Generate the barcode for each student's apogee
            $generator = new BarcodeGeneratorPNG();
            $barcode = base64_encode($generator->getBarcode($student->apogee, $generator::TYPE_CODE_128));

            // Render the HTML content using the Blade template for each student
            $html = view('student-avatar-list', compact('student', 'barcode'))->render();

            // Add a new page for each student
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);
        }

        // Output the PDF as a download
        return $mpdf->Output('student-avatar-list', 'I');
    }
}

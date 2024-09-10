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
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => [153.089, 243.307], // Dimensions in pt for landscape
            'orientation' => 'L'
        ]);

        // Set document information
        $mpdf->SetTitle('Student Avatar List');

        // Write HTML content to mPDF
        foreach ($students as $student) {
            // Render the HTML content using the Blade template
            $html = view('student-avatar-list', ['students' => [$student]])->render();

            // Add a page for each student
            $mpdf->AddPage();
            $mpdf->WriteHTML($html);
        }

        // Output the PDF as a download
        return $mpdf->Output('student-avatar-list.pdf', 'I');
    }
}

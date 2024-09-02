<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retrait;
use App\Models\Etudiant;
use App\Models\Diplome;
use App\Models\Laureat;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Support\Facades\DB;
use PDF;
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

        $validated = $request->validate([
            'annee' => 'required',
            'filiere' => 'required',
            'annee_uni' => 'required'
        ]);

        $students = DB::table('t_etudiant')
            ->join('users', 't_etudiant.user_id', '=', 'users.id')
            ->where('t_etudiant.Annee', $validated['annee'])
            ->where('t_etudiant.FILIERE', $validated['filiere'])
            ->where('t_etudiant.annee_uni', $validated['annee_uni'])
            ->where('t_etudiant.is_active', '1')
            ->select(
                't_etudiant.*',
                'users.image as user_image'
            )
            ->get();

            foreach ($students as $student) {
                // Convert to a public URL for displaying in the PDF
                $student->user_image = url('storage/' . $student->user_image);
        }

        $pdf = PDF::loadView('student-avatar-list', compact('students'))
            ->setPaper('a4', 'portrait');

            return $pdf->stream('student-avatar-list.pdf');
        }
}

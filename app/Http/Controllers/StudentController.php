<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retrait;
use App\Models\Etudiant;
use App\Models\Diplome;
use App\Models\Laureat;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Retrait;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Diplome;
use App\Models\Laureat;
use Illuminate\Support\Facades\Storage;

class RetraitController extends Controller
{
    public function index($id_etu)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'index';
        $students = Etudiant::with(['retraits' => function ($query) {
            $query->where('type_retrait', 'provisoire');
        }])->get();

        $isLaureat = Laureat::where('id_etu', $id_etu)->exists();

        return view('retraits', compact('active_tab', 'id_etu', 'students','isLaureat',));
    }

    public function storeretrait(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $request->validate([
            'fileType' => 'required|string',
            'textInput' => 'nullable|string',
            'dossier' => 'required|file|mimes:pdf,doc,docx|max:30720',
            'id_etu' => 'required|integer|exists:t_etudiant,id',
        ]);

        $etudiant = Etudiant::find($request->id_etu);
        if (!$etudiant) {
            return redirect()->back()->with('error', 'Etudiant not found');
        }

        $apogee = $etudiant->apogee;

        if ($request->hasFile('dossier')) {
            $fileType = $request->fileType;
            $filename = $fileType . '-' . $apogee . '.' . $request->file('dossier')->getClientOriginalExtension();
            $dossierPath = $request->file('dossier')->storeAs('retraits', $filename, 'public');
        }


        Retrait::create([
            'id_etu' => $request->id_etu,
            'type_retrait' => $request->fileType,
            'motif_retrait' => $request->textInput,
            'dossier_retrait' => $dossierPath,
        ]);

        $etudiant->update(['is_active' => 0]);

        return redirect()->back()->with('success', 'Retrait enregistré avec succès');
    }

    public function activate($id_etu)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $etudiant = Etudiant::find($id_etu);
        if (!$etudiant) {
            return redirect()->back()->with('error', 'Etudiant not found');
        }

        $etudiant->update(['is_active' => 1]);

        return redirect()->back()->with('success', 'Etudiant activé avec succès');
    }

    public function storelaureat($id_etu)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'storelaureat';
        $diplomas = Diplome::all();

        return view('storelaureats', compact('active_tab', 'id_etu', 'diplomas'));
    }

    public function storelaureatPost(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        try {
            $request->validate([
                'fileType' => 'required|string',
                'diplome' => 'required|integer|exists:t_diplome,id',
                'academicYear' => 'required|string|regex:/^\d{4}-\d{4}$/',
                'dossierloaureat' => 'required|file|mimes:pdf,doc,docx|max:30720', // 30MB max file size
                'id_etu' => 'required|integer|exists:t_etudiant,id',
            ]);

            $etudiant = Etudiant::find($request->id_etu);
            if (!$etudiant) {
                return redirect()->back()->with('error', 'Etudiant not found');
            }

            $apogee = $etudiant->apogee;
            $fileType = $request->fileType;
            $academicYear = $request->academicYear;
            $currentYear = explode('-', $academicYear)[0];

            if ($request->hasFile('dossierloaureat')) {
                $filename = $apogee . '-' . strtolower($fileType) . '.' . $request->file('dossierloaureat')->getClientOriginalExtension();
                $directory = 'laureats/' . $currentYear;
                $dossierPath = $request->file('dossierloaureat')->storeAs($directory, $filename, 'public');
            }

            Laureat::create([
                'diplome' => $request->diplome,
                'id_etu' => $request->id_etu,
                'path_dossier_lautreat' => $dossierPath,
                'annee_uni' => $academicYear,
            ]);

            return redirect()->back()->with('success', 'Laureat enregistré avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }
}

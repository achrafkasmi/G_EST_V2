<?php

namespace App\Http\Controllers;

use App\Models\Retrait;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use Illuminate\Support\Facades\Storage;

class RetraitController extends Controller
{
    public function index($id_etu)
    {
        $active_tab = 'index';
        $students = Etudiant::with(['retraits' => function ($query) {
            $query->where('type_retrait', 'provisoire');
        }])->get();
        
        return view('retraits', compact('active_tab', 'id_etu', 'students',));
    }

    public function storeretrait(Request $request)
    {
        $request->validate([
            'fileType' => 'required|string',
            'textInput' => 'nullable|string',
            'dossier' => 'required|file|mimes:pdf,doc,docx|max:30720', // 30 MB max file size
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
        $etudiant = Etudiant::find($id_etu);
        if (!$etudiant) {
            return redirect()->back()->with('error', 'Etudiant not found');
        }
        //$retrait = Retrait::where('id_etu', $id_etu)->where('type_retrait', 'provisoire')->first();

        $etudiant->update(['is_active' => 1]);

        return redirect()->back()->with('success', 'Etudiant activé avec succès');
    }

    public function storelaureat($id_etu){

        $active_tab = 'storelaureat';

        return view('storelaureats', compact('active_tab', 'id_etu'));

    }
}

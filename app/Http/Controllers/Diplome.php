<?php

namespace App\Http\Controllers;

use App\Models\Diplome as ModelsDiplome;
use App\Models\EtapeDiplome;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Personnel;

class Diplome extends Controller
{

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        // Validate the incoming request data
        $validatedData = $request->validate([
            'intitule_diplome_fr' => 'required|string',
            'intitule_diplome_ar' => 'nullable|string',
            'code_diplome' => 'required|string',
            'date_accreditation' => 'required|date',
            'anne_debut_accreditation' => 'required|integer',
            'anne_fin_accreditation' => 'required|integer',
            'id_personnel' => 'required|string',
        ]);

        // Convert the date to the correct format
        $date_accreditation = Carbon::createFromFormat('m/d/Y', $validatedData['date_accreditation'])->format('Y-m-d');

        // Create a new instance of Diplome model
        $diplome = new ModelsDiplome();
        $diplome->intitule_diplome_fr = $validatedData['intitule_diplome_fr'];
        $diplome->intitule_diplome_ar = $validatedData['intitule_diplome_ar'];
        $diplome->code_diplome = $validatedData['code_diplome'];
        $diplome->date_accreditation = $date_accreditation;
        $diplome->anne_debut_accreditation = $validatedData['anne_debut_accreditation'];
        $diplome->anne_fin_accreditation = $validatedData['anne_fin_accreditation'];
        $diplome->id_personnel = $validatedData["id_personnel"];

        // Save the Diplome instance
        $diplome->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Diplome ajouté avec succès.');
    }
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $personnel = Personnel::all();
        $diplomes = ModelsDiplome::all();
        $active_tab = 'diplomes';
        return view('modules', compact('diplomes', 'personnel', 'active_tab'));
    }

    public function storeEtapeDiplome(Request $request)
    {
        try {
            if (!auth()->user()->hasRole('admin')) {
                abort(403);
            }
            // Validate the incoming request data
            $validatedData = $request->validate([
                'code_etape_diplome' => 'required|string|max:50',
                'nom_etape_diplome' => 'required|string|max:500',
                'id_diplome' => 'required',
            ]);

            // Create a new TEtapeDiplome instance
            $etapeDiplome = new EtapeDiplome();
            $etapeDiplome->code_etape_diplome = $validatedData['code_etape_diplome'];
            $etapeDiplome->nom_etape_diplome = $validatedData['nom_etape_diplome'];
            $etapeDiplome->id_diplome = $validatedData['id_diplome'];
            $etapeDiplome->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Etape Diplome ajoutée avec succès!');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'ajout de l\'étape du diplôme. Veuillez réessayer.');
        }
    }
}

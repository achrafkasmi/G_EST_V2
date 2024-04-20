<?php

namespace App\Http\Controllers;

use App\Models\Diplome as ModelsDiplome;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Diplome extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'intitule_diplome_fr' => 'required|string',
            'intitule_diplome_ar' => 'nullable|string',
            'code_diplome' => 'required|string',
            'date_accreditation' => 'required|date',
            'anne_debut_accreditation' => 'required|integer',
            'anne_fin_accreditation' => 'required|integer',
            'id_personnel'=>'required|string',
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
        $diplome->id_personnel= $validatedData[ "id_personnel"];

        // Save the Diplome instance
        $diplome->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Diplome ajouté avec succès.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ElementPedagogique;
use App\Models\Personnel;



use Illuminate\Http\Request;

class ElementPedagogiqueController extends Controller
{
    public function fetchData($id, $etape_id)
    {    
        // Fetch all rows from the t_modules_etape table
        $elements = ElementPedagogique::where('id_etape', $etape_id)->get();
        $active_tab = 'gestionelements';

        // Fetch the list of teachers
        $teachers = $this->listPersonnel();

        // Pass the fetched data to the view
        return view('elementspedago', compact('active_tab', 'elements', 'etape_id', 'id', 'teachers'));
    }

    public function store(Request $request, $id, $etape_id)
    {
        // Validate the request data
        $request->validate([
            'code_etape' => 'nullable|string|max:50',
            'id_etape' => 'required|integer',
            'type_etape_element' => 'nullable|string|max:30',
            'intitule_element' => 'nullable|string|max:100',
            'nbr_heures_cours' => 'nullable|numeric',
            'nbr_heures_td' => 'nullable|numeric',
            'nbr_heures_tp' => 'nullable|numeric',
            'nbr_heures_ap' => 'nullable|numeric',
            'nbr_heures_evaluation' => 'nullable|numeric',
            'decription_module' => 'nullable|string',
            'coefficient' => 'nullable|numeric',
        ]);

        // Create a new ElementPedagogique instance and save the data
        ElementPedagogique::create($request->all());

        // Redirect back with a success message
        return redirect()->route('elementspedago', ['id' => $id, 'etape_id' => $etape_id])
            ->with('success', 'Module ajouté avec succès');
    }

    public function listPersonnel()
    {
        return Personnel::pluck('nom_personnel', 'id');
    }
}

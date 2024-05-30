<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Element;
use App\Models\ElementPedagogique;
use App\Models\EtapeDiplome;
use App\Models\Diplome;



class ElementController extends Controller
{
    
    public function index(int $id_diplome)
    {
        $diplomes = Diplome::all();
        $active_tab = 'gestionelements';
        $etapes = EtapeDiplome::where('id_diplome', $id_diplome)->get();
        
        return view('gestionelements', compact('etapes','diplomes', 'active_tab', 'id_diplome'));
    }

}


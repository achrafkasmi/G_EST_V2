<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Element;
use App\Models\ElementPedagogique;
use App\Models\EtapeDiplome;



class ElementController extends Controller
{
    /*public function index(int $module_parent)
    {
        $active_tab = 'gestionelements';
        $elements = Element::where('module_parent', $module_parent)->get();
        return view('gestionelements', compact('elements', 'active_tab', 'module_parent'));
    }*/
    public function index(int $id_diplome)
    {
        $active_tab = 'gestionelements';
        $etapes = EtapeDiplome::where('id_diplome', $id_diplome)->get();
        
        return view('gestionelements', compact('etapes', 'active_tab', 'id_diplome'));
    }




}

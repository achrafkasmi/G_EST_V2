<?php

namespace App\Http\Controllers;
use App\Models\ElementPedagogique;


use Illuminate\Http\Request;

class ElementPedagogiqueController extends Controller
{
    public function fetchData($id,$etape_id)
{    // Fetch all rows from the t_modules_etape table
    $elements = ElementPedagogique::where('id_etape',$etape_id)->get();
    $active_tab = 'gestionelements';
    // Pass the fetched data to the view
    return view('elementspedago', compact('active_tab','elements','etape_id'));
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retrait;
use App\Models\Etudiant;
use App\Models\Diplome;
use App\Models\Laureat;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(){
        $active_tab = 'stumana';
        return view('studentmanagement', compact( 'active_tab'));
    }
}

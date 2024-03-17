<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;

class libraryController extends Controller
{
    public function recommand($id){
        $student= User::where('id',$id)->first()->etudiant;
        if($student){
            $student->stage->is_recommanded=true;
            $student->stage->save();
        }
        return redirect('/dash');
    }
}

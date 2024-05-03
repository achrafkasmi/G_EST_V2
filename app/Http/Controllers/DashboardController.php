<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('teacher') && auth()->user()->personnel) {

            $diplomes = auth()->user()->personnel->diplomes;
            
            $etudiants = [];
            $users = [];

            foreach ($diplomes as $diplome) {
                
                foreach ($diplome->etudiants as $etudiant) {

                    if($etudiant->user->is_uploaded){

                        $users[] = $etudiant->user;
                    }
                }
            }
            
            return  view('Dashboards.dashteacher')->with(['users' => $users,'active_tab' => 'dash']);
        }

        return  view('Dashboards.dashboard')->with(['active_tab' => 'dash']);
    }

    public function dashteacher()
    {
        $users = User::where('is_uploaded', true)->get();
        return view('Dashboards.dashteacher')->with(['users' => $users]);          
    }

    public function myIntern(): View
    {
        if (!auth()->user()->hasRole('student')) {

            abort(403);
        }
        return view('messtages')->with(['active_tab' => 'messtages']);
    }   
}


    
    

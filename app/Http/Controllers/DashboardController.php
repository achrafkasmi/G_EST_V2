<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stage;
use App\Models\Etudiant;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('teacher') && auth()->user()->personnel) {
            
            $personnelId = auth()->user()->personnel->id;
    
           
            $dossierStages = Stage::where('professeur_encadrant_id', $personnelId)->get();
    
            $etudiantIds = $dossierStages->pluck('id_etu')->toArray();
    
            // Mapping  l etudiant IDs to corresponding user IDs in the users table
            $userIds = Etudiant::whereIn('id', $etudiantIds)->pluck('user_id')->toArray();
    
            $users = User::whereIn('id', $userIds)->get();
    
         
            $uploadedUsers = $users->filter(function ($user) {
                return $user->is_uploaded == true;
            });
    
            return view('Dashboards.dashteacher')->with(['users' => $uploadedUsers, 'active_tab' => 'dash']);
        }
    
        return view('Dashboards.dashboard')->with(['active_tab' => 'dash']);
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

        // Call the listPersonnel method to fetch teachers
        $teachers = $this->listPersonnel();

        return view('messtages', ['active_tab' => 'messtages', 'teachers' => $teachers]);
    }

    public function listPersonnel()
    {
        return Personnel::pluck('nom_personnel', 'id');
    }
}

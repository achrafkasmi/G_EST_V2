<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stage;
use App\Models\Etudiant;
use App\Models\Laureat;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        // Check if the user has the role of teacher and has a personnel record
        if (auth()->user()->hasRole('teacher') && auth()->user()->personnel) {
            $personnelId = auth()->user()->personnel->id;

            // Eager loading to fetch related models upfront
            $dossierStages = Stage::with('etudiant.user')->where('professeur_encadrant_id', $personnelId)->get();

            // Collection to store users with their stages
            $users = collect([]);

            // Group stages by user
            foreach ($dossierStages as $stage) {
                $userId = $stage->etudiant->user->id;

                // Check if the user already exists in the collection
                $userKey = $users->search(function ($user) use ($userId) {
                    return $user['id'] == $userId;
                });

                if ($userKey === false) {
                    $users->push([
                        'id' => $userId,
                        'name' => $stage->etudiant->user->name,
                        'stages' => collect([$stage]), // Initialize a collection for stages
                    ]);
                } else {
                    // If the user already exists, push the stage to their stages collection
                    $users[$userKey]['stages']->push($stage);
                }
            }

            return view('Dashboards.dashteacher')->with(['users' => $users, 'active_tab' => 'dash']);
        }

        // Fetch all students sorted by annee_uni
        $students = Etudiant::orderBy('annee_uni')->get();

        return view('Dashboards.dashboard')->with(['students' => $students, 'active_tab' => 'dash', 'isLaureat' => 'dash']);
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

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
use App\Http\Controllers\Controller;
use App\Http\Controllers\AttendanceController;


class DashboardController extends Controller
{
    /*public function index()
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

        //all students are 100% donc here calcule pourcentage sur chaque filière
        $students = Etudiant::orderBy('annee_uni')->get();
        $totalStudents = Etudiant::count();
        $filieres = Etudiant::select('filiere', \DB::raw('count(*) as count'))
            ->groupBy('filiere')
            ->get();

        foreach ($filieres as $filiere) {
            $filiere->percentage = ($filiere->count / $totalStudents) * 100;
        }

        $colors = ['#4caf50', '#2196f3', '#ff9800', '#e91e63', '#9c27b0', '#3f51b5', '#009688', '#cddc39', '#ff5722', '#607d8b'];


        return view('Dashboards.dashboard')->with([
            'students' => $students,
            'filieres' => $filieres,
            'active_tab' => 'dash',
            'colors' => $colors,
            'isLaureat' => 'dash'
        ]);
    }*/

   /* public function index()
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

        // For students, calculate attendance rate
        $attendanceController = new AttendanceController();
        $attendanceData = $attendanceController->studentAttendanceRate();

        // Calculate percentage of students in each filiere
        $students = Etudiant::orderBy('annee_uni')->get();
        $totalStudents = Etudiant::count();
        $filieres = Etudiant::select('filiere', \DB::raw('count(*) as count'))
            ->groupBy('filiere')
            ->get();

        foreach ($filieres as $filiere) {
            $filiere->percentage = ($filiere->count / $totalStudents) * 100;
        }

        $colors = ['#4caf50', '#2196f3', '#ff9800', '#e91e63', '#9c27b0', '#3f51b5', '#009688', '#cddc39', '#ff5722', '#607d8b'];

        return view('Dashboards.dashboard')->with([
            'students' => $students,
            'filieres' => $filieres,
            'active_tab' => 'dash',
            'colors' => $colors,
            'isLaureat' => 'dash',
        ])->with($attendanceData->getData());
    }*/

    public function index()
{
    $user = auth()->user();

    // Check if the user has the role of teacher and has a personnel record
    if ($user->hasRole('teacher') && $user->personnel) {
        $personnelId = $user->personnel->id;

        $dossierStages = Stage::with('etudiant.user')->where('professeur_encadrant_id', $personnelId)->get();
        $users = collect([]);

        foreach ($dossierStages as $stage) {
            if ($stage->etudiant && $stage->etudiant->user) {
                $userId = $stage->etudiant->user->id;

                $userKey = $users->search(function ($user) use ($userId) {
                    return $user['id'] == $userId;
                });

                if ($userKey === false) {
                    $users->push([
                        'id' => $userId,
                        'name' => $stage->etudiant->user->name,
                        'stages' => collect([$stage]),
                    ]);
                } else {
                    $users[$userKey]['stages']->push($stage);
                }
            }
        }

        return view('Dashboards.dashteacher')->with(['users' => $users, 'active_tab' => 'dash']);
    }

    // For students, calculate attendance rate
    if ($user->hasRole('student')) {
        $attendanceController = new AttendanceController();
        $attendanceData = $attendanceController->studentAttendanceRate();

        $students = Etudiant::orderBy('annee_uni')->get();
        $totalStudents = Etudiant::count();
        $filieres = Etudiant::select('filiere', \DB::raw('count(*) as count'))
            ->groupBy('filiere')
            ->get();

        foreach ($filieres as $filiere) {
            $filiere->percentage = ($filiere->count / $totalStudents) * 100;
        }

        $colors = ['#4caf50', '#2196f3', '#ff9800', '#e91e63', '#9c27b0', '#3f51b5', '#009688', '#cddc39', '#ff5722', '#607d8b'];

        return view('Dashboards.dashboard')->with([
            'students' => $students,
            'filieres' => $filieres,
            'active_tab' => 'dash',
            'colors' => $colors,
            'isLaureat' => 'dash',
        ])->with($attendanceData);
    }

    // For admins,we  handle admin-specific data
    if ($user->hasRole('admin')) {
        $students = Etudiant::orderBy('annee_uni')->get();
        $totalStudents = Etudiant::count();
        $filieres = Etudiant::select('filiere', \DB::raw('count(*) as count'))
            ->groupBy('filiere')
            ->get();

        foreach ($filieres as $filiere) {
            $filiere->percentage = ($filiere->count / $totalStudents) * 100;
        }

        $colors = ['#4caf50', '#2196f3', '#ff9800', '#e91e63', '#9c27b0', '#3f51b5', '#009688', '#cddc39', '#ff5722', '#607d8b'];

        return view('Dashboards.dashboard')->with([
            'students' => $students,
            'filieres' => $filieres,
            'active_tab' => 'dash',
            'colors' => $colors,
            'isLaureat' => 'dash',
        ]);
    }

    abort(403, 'Unauthorized action.');
}

















    /*public function dashteacher()
    {
        if (!auth()->user()->hasRole('teacher')) {
            abort(403);
        }
        $users = User::where('is_uploaded', true)->get();
        return view('Dashboards.dashteacher')->with(['users' => $users]);
    } version of this dashteacher has beeen updated on the index function*/

    public function myIntern(): View
    {
        if (!auth()->user()->hasRole('student')) {
            abort(403);
        }

        $teachers = $this->listPersonnel();

        return view('messtages', ['active_tab' => 'messtages', 'teachers' => $teachers]);
    }

    public function listPersonnel()
    {
        return Personnel::pluck('nom_personnel', 'id');
    }
}

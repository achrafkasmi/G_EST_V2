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
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
    
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


    public function getStudentCount()
    {
        $studentCounts = DB::table('t_etudiant')
            ->select(DB::raw('annee_uni, COUNT(*) as student_count'))
            //->where('is_active', 1)
            ->groupBy('annee_uni')
            ->get();
    
        return response()->json($studentCounts);
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

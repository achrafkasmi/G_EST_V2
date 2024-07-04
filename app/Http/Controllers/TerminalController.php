<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TerminalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Ensure user is authenticated
    }

    public function index()
    {
        $active_tab = 'reports';

        return view('terminal', compact('active_tab'));
    }

    public function execute(Request $request)
    {
        $command = $request->input('command');
        $result = $this->handleCommand($command);

        return response()->json(['result' => $result]);
    }

    protected function handleCommand($command)
    {
        // Define allowed commands for security
        $allowedCommands = [
            'count usr',
            'list usr',
            'count laureats',
            'count laureats>year',
            'count laureats>diploma',
            'count laureats>diploma>year',
            'count usr>student',
            'count usr>student>activity',
            'count usr>student>sexe>activity',
            'count usr>student>sexe>activity>byyear',
            'count student>has_uploaded',
            'list dip',
            'list staff>teacher'
        ];

        if (!in_array($command, $allowedCommands)) {
            return 'Error: Unknown or disallowed command';
        }

        // Process command
        switch ($command) {
            case 'count usr':
                return DB::table('users')->count();
            case 'list usr':
                return DB::table('users')->select('id', 'name', 'email')->get()->toArray();
            case 'count laureats':
                return DB::table('t_laureat')->count();
            case 'count laureats>year':
                return DB::table('t_laureat')->select('annee_uni', DB::raw('count(*) as total'))
                    ->groupBy('annee_uni')
                    ->get()->toArray();
            case 'count laureats>diploma':
                return DB::table('t_laureat')->select('diplome', DB::raw('count(*) as total'))
                    ->groupBy('diplome')
                    ->get()->toArray();
            case 'count laureats>diploma>year':
                return DB::table('t_laureat')->select('diplome', 'annee_uni', DB::raw('count(*) as total'))
                    ->groupBy('diplome', 'annee_uni')
                    ->get()->toArray();
            case 'count usr>student':
                return DB::table('t_etudiant')->count();
            case 'count usr>student>activity':
                $activeCount = DB::table('t_etudiant')->where('is_active', 1)->count();
                $inactiveCount = DB::table('t_etudiant')->count() - $activeCount;
                return ['active' => $activeCount, 'inactive' => $inactiveCount];
            case 'count usr>student>sexe>activity':
                $activeBoys = DB::table('t_etudiant')->where('sexe', 'male')->where('is_active', 1)->count();
                $activeGirls = DB::table('t_etudiant')->where('sexe', 'female')->where('is_active', 1)->count();
                return ['activeMale' => $activeBoys, 'activeFemale' => $activeGirls];
            case 'count usr>student>sexe>activity>byyear':
                return DB::table('t_etudiant')
                    ->select('annee_uni', 'sexe', DB::raw('count(*) as total'))
                    ->where('is_active', 1)
                    ->groupBy('annee_uni', 'sexe')
                    ->get()->toArray();
            case 'count student>has_uploaded':
                return DB::table('t_dossier_stage')
                    ->select(
                        'annee_universitaire',
                        DB::raw('sum(is_uploaded_initiation) as uploaded_initiation'),
                        DB::raw('sum(is_uploaded_technique) as uploaded_technique'),
                        DB::raw('sum(is_uploaded_pfe) as uploaded_pfe'),
                        DB::raw('sum(is_uploaded_professionelle) as uploaded_professionelle')
                    )
                    ->groupBy('annee_universitaire')
                    ->get()->toArray();
            case 'list dip':
                return DB::table('t_diplome')->select(
                    'id',
                    'id_personnel',
                    'code_diplome',
                    'intitule_diplome_fr',
                    'intitule_diplome_ar',
                    'date_accreditation',
                    'anne_debut_accreditation',
                    'anne_fin_accreditation'
                )->get()->toArray();
            case 'list staff>teacher':
                return DB::table('t_personnel')->select(
                    'id',
                    'code_personnel',
                    'nom_personnel',
                    'user_id'
                )->whereNotNull('user_id')->get()->toArray();
            default:
                return 'Unknown command';
        }
    }
}

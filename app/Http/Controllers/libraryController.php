<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Library;
use App\Models\Stage;
use App\Models\User;
use CreateTDossierStageTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class libraryController extends Controller
{
    public function recommand($id)
    {
        $student = User::where('id', $id)->first()->etudiant;
        if ($student) {
            $student->stage->is_recommanded = true;
            $student->stage->save();

            $rapport_pdf_name = 'Rapport-' . $student->apogee . '.pdf';

            $sourceFilePath = storage_path('app/public/uploads/' . $rapport_pdf_name);

            $destinationFolder = 'app/public/library/';

            if (file_exists($sourceFilePath)) {

                Storage::put('public/library/stage/' . $rapport_pdf_name, file_get_contents($sourceFilePath));
            }
        }

        return redirect('/dash');
    }


    public function validationstage($id)
    {
        $student = User::where('id', $id)->first()->etudiant;
        if ($student) {
            if($student->stage->validation_prof) $student->stage->validation_prof = false;
            else $student->stage->validation_prof = true;
            $student->stage->save();
        }

        return redirect('/dash');
    }


    public function unvalidatestage($id)
    {
        $student = User::where('id', $id)->first()->etudiant;
        if ($student) {
            $student->stage->validation_prof = false;
            $student->stage->save();
        }
    }
    //hadi drtha pour datatable dyal admin bach ichouf all stages uploaded and accepeted
    public function index()
    {
        $dossierStages = Stage::all();
        return view('gestionstage', compact('dossierStages'))->with(['active_tab' => 'gestionstage']);
    }



    public function fetchlibrary()
    {
        $dossierStages = Library::where('is_recommanded', 1)->get();
        return view('library')->with(['dossierStages' => $dossierStages,'active_tab' => 'library']);
    }
}

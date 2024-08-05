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
    public function recommand($stageId)
    {
        if (!auth()->user()->hasRole('teacher')) {
            abort(403);
        }

        $stage = Stage::find($stageId);

        if ($stage) {
            $student = $stage->etudiant;
            if (!$student) {
                return redirect()->back()->with('error', 'Student not found');
            }

            // Toggle the state of is_recommanded
            $stage->is_recommanded = !$stage->is_recommanded;
            $stage->save();

            // Handle file operations
            $rapport_pdf_name = 'Rapport-' . $student->apogee . '.pdf';
            $sourceFilePath = storage_path('app/public/uploads/' . $rapport_pdf_name);
            $destinationFolder = storage_path('app/public/library/stage/');

            if ($stage->is_recommanded && file_exists($sourceFilePath)) {
                // Move the file to the library folder if recommended
                Storage::copy('public/uploads/' . $rapport_pdf_name, 'public/library/stage/' . $rapport_pdf_name);
            } elseif (!$stage->is_recommanded && Storage::exists('public/library/stage/' . $rapport_pdf_name)) {
                // Remove the file from the library folder if not recommended
                Storage::delete('public/library/stage/' . $rapport_pdf_name);
            }

            return redirect('/dash');
        } else {
            // Handle case where stage is not found
            return redirect()->back()->with('error', 'Stage not found');
        }
    }



    public function validationstage($stageId)
    {
        if (!auth()->user()->hasRole('teacher')) {
            abort(403);
        }

       
        $stage = Stage::find($stageId);

        if ($stage) {
            // Check if validation_admin is 1, if so, return without performing any actions
            if ($stage->validation_admin == 1) {
                return redirect('/dash')->with('error', 'Validation admin is enabled. Actions disabled.');
            }

            // Toggle validation_prof
            $stage->validation_prof = !$stage->validation_prof;

            // Set is_recommanded to 0 if validation_prof is 0
            if ($stage->validation_prof == 0) {
                $stage->is_recommanded = 0;
            }

            $stage->save();
        }

        return redirect('/dash');
    }






    public function unvalidatestage($id)
    {
        if (!auth()->user()->hasRole('teacher')) {
            abort(403);
        }
        $student = User::where('id', $id)->first()->etudiant;
        if ($student) {
            $student->stage->validation_prof = false;
            $student->stage->save();
        }
    }


    //hadi drtha pour datatable dyal admin bach ichouf all stages uploaded and accepeted
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $dossierStages = Stage::all();

        return view('gestionstage', compact('dossierStages'))->with(['active_tab' => 'gestionstage']);
    }



    public function fetchlibrary()
    {
        $dossierStages = Library::where('is_recommanded', 1)->get();

        return view('library')->with(['dossierStages' => $dossierStages, 'active_tab' => 'library']);
    }






    public function approveDossier(Request $request, $dossierId)
    {
        // Validate the request if needed
        // Find the dossier
        $dossier = Stage::find($dossierId);
        
        // If dossier is found, toggle the approval status
        if ($dossier) {
            // Check the current state of validation_admin
            if ($dossier->validation_admin) {
                // If already approved, revoke approval
                $dossier->validation_admin = 0;
                $flashMessage = 'Dossier approval revoked successfully';
            } else {
                // If not approved, approve
                $dossier->validation_admin = 1;
                $flashMessage = 'Dossier approved successfully';
            }

            // Save the changes
            $dossier->save();

            // Set flash message
            session()->flash('success', $flashMessage);

            return redirect()->back();
        } else {
            session()->flash('error', 'Dossier not found');
            return redirect()->back();
        }
    }
}

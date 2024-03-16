<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;


class UploadManager extends Controller
{
    // Display the upload form
    public function upload()
    {
        return view('messtages');
    }

    // Handle the file uploads
    public function uploadPost(Request $request)
    {

        $user = auth()->user();
        //dd($user->roles->pluck('name'));

        if (!Gate::denies('student', $user)) {
            abort(403);
        }
        // Validate and process the uploaded files
        
            //$request->validate([
              //  'stageFile' => 'required|mimes:pdf|max:5120', // Assuming PDF file and max 5MB
                //'rapportFile' => 'required|mimes:pdf|max:5120', // Assuming PDF file and max 5MB
            //]);

            $dossier_pdf_name = 'Dossier-'.$user->apogee;

            $rapport_pdf_name = 'Rapport-'.$user->apogee;

            $path = "public/uploads/";

            $stageFilename = $request->input('stageFilename',$dossier_pdf_name) . '.pdf';

            $rapportFilename = $request->input('rapportFilename',$rapport_pdf_name) . '.pdf';

            // Store the files in the storage/app/public/uploads directory with custom filenames
            $stageFilePath = $request->file('stageFile')->storeAs('uploads', $stageFilename, 'public');

            $rapportFilePath = $request->file('rapportFile')->storeAs('uploads', $rapportFilename, 'public');

            $stage = Stage::where('id_etu',$user->etudiant->id)->first() ?? new Stage();

            $stage->id_etu = $user->etudiant->id;

            $stage->type_dossier = $request->get('fileType');

            $stage->rapport = $path.$rapport_pdf_name. '.pdf';

            $stage->dossier_stage = $path.$dossier_pdf_name. '.pdf';

            $stage->save();


            $user->is_uploaded = true;

            $user->save();


            return redirect()->route('dashboard')->with('success', 'Files uploaded successfully!');
       
    }

    
}

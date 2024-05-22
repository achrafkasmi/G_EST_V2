<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\PdfToImage\Pdf;

class UploadManager extends Controller
{
    public function upload()
    {
        return view('messtages', [
            'dossierStages' => Stage::orderBy('created_at', 'desc')->get(), // Sort by created_at in descending order by default
        ]);
    }

   public function uploadPost(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'fileType'     => 'required',
        'stageFile'    => $request->input('fileType') !== 'PFE' ? 'required|mimes:pdf|max:7168' : 'nullable|mimes:pdf|max:7168',
        'rapportFile'  => 'required|mimes:pdf|max:7168',
        'textInput'    => 'required|string|max:255',
        'teacherSelect'=> 'required',
    ]);

    $apogee = $user->apogee;

    $dossier_pdf_name = 'Dossier-' . $apogee . '.pdf';
    $rapport_pdf_name = 'Rapport-' . $apogee . '.pdf';
    $pagegarde_image_name = 'PageGarde-' . $apogee . '.jpg';

    $path = "public/uploads/";
    $selectedTeacherId = $request->input('teacherSelect');
    $stageFilePath = $request->file('stageFile') ? $request->file('stageFile')->storeAs('uploads', $dossier_pdf_name, 'public') : null;
    $rapportFilePath = $request->file('rapportFile')->storeAs('uploads', $rapport_pdf_name, 'public');

    // Converting the first page of the rapport PDF to a JPG image using Spatie\PdfToImage
    $pdf = new Pdf(storage_path("app/public/uploads/{$rapport_pdf_name}"));
    $pdf->setPage(1);
    $pdf->setResolution(300);
    $pdf->setOutputFormat('jpg');
    $imagePath = $pdf->saveImage(storage_path("app/public/uploads/{$pagegarde_image_name}"));

    // Create a new Stage record for each file upload
    $stage = new Stage();
    $stage->id_etu = $user->etudiant->id;
    $stage->type_dossier = $request->input('fileType');
    $stage->rapport = $path . $rapport_pdf_name;
    $stage->dossier_stage = $request->input('fileType') === 'PFE' ? 'none' : ($stageFilePath ? $path . $dossier_pdf_name : null);
    $stage->image_page_garde = $path . $pagegarde_image_name;
    $stage->titre_rapport = $request->input('textInput');
    $stage->professeur_encadrant_id = $selectedTeacherId;

    // Set the relevant column to true based on file type
    switch ($request->input('fileType')) {
        case 'Stage d\'initiation':
            $stage->is_uploaded_initiation = true;
            break;
        case 'Stage professionnel':
            $stage->is_uploaded_professionelle = true;
            break;
        case 'Stage technique':
            $stage->is_uploaded_technique = true;
            break;
        case 'PFE':
            $stage->is_uploaded_pfe = true;
            break;
    }

    $stage->save();

    $request->session()->flash('success', 'Files were uploaded successfully!');

    return redirect()->back();
}














public function edit($stageId)
{
    // Find the stage record based on the given Stage ID
    $stage = Stage::findOrFail($stageId);

    // Check if the stage belongs to the authenticated user
    if ($stage->id_etu != auth()->user()->etudiant->id) {
        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    // Check if the 'validation_prof' column is set to 1
    if ($stage->validation_prof == 1) {
        return redirect()->back()->with('error', 'This action cannot be performed as the stage has already been validated by the professor.');
    }

    // Remove the stored related files from the storage
    Storage::delete([
        $stage->rapport,
        $stage->dossier_stage,
        $stage->image_page_garde,
    ]);

    // Delete the specific row
    $stage->delete();

    return redirect()->back()->with('success', 'Files and related data have been successfully removed.');
}

}

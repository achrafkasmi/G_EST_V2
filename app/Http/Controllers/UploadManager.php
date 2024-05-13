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

        // Convert the first page of the rapport PDF to a JPG image using Spatie\PdfToImage
        $pdf = new Pdf(storage_path("app/public/uploads/{$rapport_pdf_name}"));
        $pdf->setPage(1); //setting the first page page de garde
        $pdf->setResolution(300);
        $pdf->setOutputFormat('jpg');
        $imagePath = $pdf->saveImage(storage_path("app/public/uploads/{$pagegarde_image_name}"));

        // Save the stage information
        $stage = Stage::where('id_etu', $user->etudiant->id)->first() ?? new Stage();
        $stage->id_etu = $user->etudiant->id;
        $stage->type_dossier = $request->input('fileType');
        $stage->rapport = $path . $rapport_pdf_name;
        $stage->dossier_stage = $request->input('fileType') === 'PFE' ? 'none' : ($stageFilePath ? $path . $dossier_pdf_name : null);
        $stage->image_page_garde = $path . $pagegarde_image_name; // Store image path with .jpg extension
        $stage->titre_rapport = $request->input('textInput');
        $stage->professeur_encadrant_id = $selectedTeacherId;

        $stage->save();

        $user->is_uploaded = true;
        $user->save();

        $request->session()->flash('success', 'Files were uploaded successfully!');

        return redirect()->back();
    }















    public function edit($id)
    {
        $user = User::findOrFail($id);

        // Check if 'is_uploaded' is 1 and make it 0 in the 'users' table
        if ($user->is_uploaded) {
            $user->is_uploaded = 0;
            $user->save();
        }

        // Remove the line related to this 'id' of users from the linked table 't_dossier_stage'
        Stage::where('id_etu', $user->etudiant->id)->delete();

        // Remove the stored related files from the storage
        Storage::delete([
            'public/uploads/Dossier-' . $user->apogee . '.pdf',
            'public/uploads/Rapport-' . $user->apogee . '.pdf',
            'public/uploads/PageGarde-' . $user->apogee . '.jpg',
        ]);

        return redirect()->back()->with('success', 'Files and related data have been successfully removed.');
    }
}

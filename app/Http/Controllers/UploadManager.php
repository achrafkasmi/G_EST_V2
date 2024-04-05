<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'stageFile'    => $request->input('fileType') !== 'PFE' ? 'required|mimes:pdf|max:30720' : 'nullable|mimes:pdf|max:30720',
            'rapportFile'  => 'required|mimes:pdf|max:30720',
            'textInput'    => 'required|string|max:255',
        ]);

        $apogee = $user->apogee;

        $dossier_pdf_name = 'Dossier-' . $apogee . '.pdf';
        $rapport_pdf_name = 'Rapport-' . $apogee . '.pdf';
        $pagegarde_image_name = 'PageGarde-' . $apogee . '.jpg';

        $path = "public/uploads/";

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

        $stage->save();

        $user->is_uploaded = true;
        $user->save();

        $request->session()->flash('success', 'Files were uploaded successfully!');

        return redirect()->back();
    }
}

































//hadi it works 
/*namespace App\Http\Controllers;

use App\Models\Stage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\PdfToImage\Pdf;

class UploadManager extends Controller
{
    public function upload()
    {
        return view('messtages');
    }

    public function uploadPost(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'fileType'     => 'required',
            'stageFile'    => 'required|mimes:pdf|max:30720', 
            'rapportFile'  => 'required|mimes:pdf|max:30720', 
            'gardeFile'    => '|mimes:pdf|max:1024',
            'textInput'    => '|string|max:255',
        ]);

        $dossier_pdf_name = 'Dossier-' . $user->apogee;
        $rapport_pdf_name = 'Rapport-' . $user->apogee;
        $pagegarde_pdf_name = 'PageGarde-' . $user->apogee;

        $path = "public/uploads/";

        $stageFilename = $request->input('stageFilename', $dossier_pdf_name) . '.pdf';
        $rapportFilename = $request->input('rapportFilename', $rapport_pdf_name) . '.pdf';
        $PageGardeFilename = $request->input('PageGardeFilename', $pagegarde_pdf_name) . '.pdf';

        $stageFilePath = $request->file('stageFile')->storeAs('uploads', $stageFilename, 'public');
        $rapportFilePath = $request->file('rapportFile')->storeAs('uploads', $rapportFilename, 'public');
        $PageGardeFilePath = $request->file('gardeFile')->storeAs('uploads', $PageGardeFilename, 'public');

        // Convert the first page of the rapport PDF to an image using Spatie\PdfToImage
        $pdf = new Pdf(storage_path("app/public/uploads/{$rapportFilename}"));
        $pdf->setPage(1); // Set to the first page
        $pdf->setResolution(300);
        $pdf->setOutputFormat('png');
        $imagePath = $pdf->saveImage(storage_path("app/public/uploads/{$pagegarde_pdf_name}.png"));

        // Save the stage information
        $stage = Stage::where('id_etu', $user->etudiant->id)->first() ?? new Stage();
        $stage->id_etu = $user->etudiant->id;
        $stage->type_dossier = $request->input('fileType');
        $stage->rapport = $path . $rapport_pdf_name . '.pdf';
        $stage->dossier_stage = $path . $dossier_pdf_name . '.pdf';
        $stage->image_page_garde = $path . $pagegarde_pdf_name . '.png'; // Store image path with .png extension
        $stage->titre_rapport = $request->input('textInput'); 

        $stage->save();

        $user->is_uploaded = true;
        $user->save();

        $request->session()->flash('success', 'Files were uploaded successfully!');

        return redirect()->back();
    }
}*/















/*namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;


class UploadManager extends Controller
{
   
    public function upload()
    {
        return view('messtages');
    }

   
    public function uploadPost(Request $request)
    {

        $user = auth()->user();

        $request->validate([
            'fileType'  => ['required'],
            'stageFile' => '|mimes:pdf|max:30720', 
            'rapportFile' => 'required|mimes:pdf|max:30720', 
            'gardeFile' => 'required|mimes:pdf|max:1024',
            'textInput'  => 'required|string|max:255' 

        ]);

        $dossier_pdf_name = 'Dossier-' . $user->apogee;

        $rapport_pdf_name = 'Rapport-' . $user->apogee;

        $pagegarde_pdf_name = 'PageGarde-' . $user->apogee;

        $path = "public/uploads/";



        $stageFilename = $request->input('stageFilename', $dossier_pdf_name) . '.pdf';

        $rapportFilename = $request->input('rapportFilename', $rapport_pdf_name) . '.pdf';

        $PageGardeFilename = $request->input('PageGardeFilename', $pagegarde_pdf_name) . '.pdf';



        $stageFilePath = $request->file('stageFile')->storeAs('uploads', $stageFilename, 'public');

        $rapportFilePath = $request->file('rapportFile')->storeAs('uploads', $rapportFilename, 'public');

        $PageGardeFilePath = $request->file('gardeFile')->storeAs('uploads', $PageGardeFilename, 'public');



        $stage = Stage::where('id_etu', $user->etudiant->id)->first() ?? new Stage();

        $stage->id_etu = $user->etudiant->id;



        //$stage->type_dossier = $request->get('fileType');
        $stage->type_dossier = $request->input('fileType');

        $stage->rapport = $path . $rapport_pdf_name . '.pdf';

        $stage->dossier_stage = $path . $dossier_pdf_name . '.pdf';

        $stage->image_page_garde = $path . $pagegarde_pdf_name . 'pdf';

        $stage->titre_rapport = $request->input('textInput'); 


        $stage->save();

        $user->is_uploaded = true;

        $user->save();

        $request->session()->flash('success', 'Files were uploaded successfully!');

       
        return redirect()->back();


    }
}*/
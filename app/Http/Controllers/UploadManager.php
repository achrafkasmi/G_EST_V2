<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        // Validate and process the uploaded files
        try {
            $request->validate([
                'stageFile' => 'required|mimes:pdf|max:5120', // Assuming PDF file and max 5MB
                'rapportFile' => 'required|mimes:pdf|max:5120', // Assuming PDF file and max 5MB
            ]);


            
            $dossier_pdf_name = 'Dossier-'.Auth()->user()->apogee;
            $rapport_pdf_name = 'Rapport-'.Auth()->user()->apogee;

            $path = "public/uploads/";

            $stageFilename = $request->input('stageFilename',$dossier_pdf_name) . '.pdf';
            $rapportFilename = $request->input('rapportFilename',$rapport_pdf_name) . '.pdf';

            // Store the files in the storage/app/public/uploads directory with custom filenames
            $stageFilePath = $request->file('stageFile')->storeAs('uploads', $stageFilename, 'public');
            $rapportFilePath = $request->file('rapportFile')->storeAs('uploads', $rapportFilename, 'public');

            // You can save these file paths and filenames to the database or perform other operations as needed
            $path = "public/uploads/";
            // Generate unique filenames or let users provide their own filenames
            $user=User::where('id',Auth::user()->id)->first();
            $user->is_uploaded=true;
            $user->rapport_file=$path.$rapport_pdf_name. '.pdf';
            $user->stage_file=$path.$dossier_pdf_name. '.pdf';
            $user->save();
            // Redirect back to the form with a success message
            return redirect()->route('dashboard')->with('success', 'Files uploaded successfully!');
            
        } catch (\Exception $e) {
            // Handle the exception and return an error message to the view
            return redirect()->back()->withInput()->withErrors(['error' => 'File upload failed. Please try again.']);
        }
    }
}

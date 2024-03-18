<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
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

            $rapport_pdf_name = 'Rapport-' . $student->apogee.'.pdf';

            $sourceFilePath = storage_path('app/public/uploads/' . $rapport_pdf_name);

            $destinationFolder = 'app/public/library/';

            if (file_exists($sourceFilePath)) {

                Storage::put('public/library/stage/' . $rapport_pdf_name, file_get_contents($sourceFilePath));
            }
        }

        return redirect('/dash');
    }
}

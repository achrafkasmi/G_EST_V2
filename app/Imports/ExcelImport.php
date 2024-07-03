<?php

namespace App\Imports;

use App\Models\Etudiant;
use App\Models\EtudiantEtape;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImport implements ToCollection
{
    /**
     * @param Collection $collection
     * @return array
     */
    public function collection(Collection $rows)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 1000);

        $expectedHeaders = ['apogee', 'email1', 'cne', 'nom_ar', 'nom_fr', 'prenom_ar', 'prenom_fr', 'cin', 'id_etape', 'lieu_de_naissance_fr', 'tel', 'annee_bac','annee_uni','is_active','Annee','FILIERE'];

        if ($rows->isEmpty()) {
            return ['status' => 'error', 'message' => 'The file is empty.'];
        }

        $firstRow = $rows->first()->toArray();
        $headerMap = [];

        foreach ($expectedHeaders as $header) {
            if (!in_array($header, $firstRow)) {
                return ['status' => 'error', 'message' => "Missing expected header: $header"];
            }
            $headerMap[$header] = array_search($header, $firstRow);
        }

        $rows = $rows->slice(1);

        foreach ($rows as $row) {
            try {
                $apogee = $row[$headerMap['apogee']];
                $email = $row[$headerMap['email1']];

                $student = Etudiant::where('apogee', $apogee)->first() ?? new Etudiant;
                $user = User::where('apogee', $apogee)->orWhere('email', $email)->first() ?? new User();

                foreach ($expectedHeaders as $header) {
                    $student->{$header} = $row[$headerMap[$header]];
                }

                $student->save();

                $user->name = $student->nom_fr . ' ' . $student->prenom_fr;
                $user->email = $student->email1;
                $user->apogee = $student->apogee;
                $user->password = bcrypt($student->apogee);

                $user->save();

                $student->user_id = $user->id;
                $student->save();

                $user->assignRole('student');

                // Check if the student is already registered for the given id_etape
                if (!empty($student->id_etape) && !$student->etapes->contains('id_etape', $student->id_etape)) {
                    // If not registered, register the student in t_etudiant_etape
                    $etudiantEtape = new EtudiantEtape();
                    $etudiantEtape->id_etu = $student->id;
                    $etudiantEtape->id_etape = $student->id_etape;
                    $etudiantEtape->save();
                }
            } catch (\Exception $e) {
                return ['status' => 'error', 'message' => 'Error processing row: ' . $e->getMessage()];
            }
        }

        return ['status' => 'success', 'message' => 'Data imported successfully.'];
    }
}






/*class ExcelImport implements ToCollection
{
    
    public function collection(Collection $rows)
    {
        ini_set('memory_limit', '1024M');

        ini_set('max_execution_time', 360);

        $expectedHeaders = ['cin', 'cne', 'nom_ar', 'nom', 'prenm_ar', 'prenom', 'date_naissance', 'apogee', 'email'];

        $firstRow = null;

        if (!$rows->isEmpty()) {

            $firstRow = $rows->first()->toArray(); // Get the first row as an associative array

            $hasExpectedHeaders = true;
        } else {
            return;
        }

        if ($hasExpectedHeaders) {

            $rows = $rows->slice(1);
        }

        $i = 0;

        foreach ($rows as $row) {

            $apogee = $row[0];

            $email = $row[1];

            $student = Etudiant::where('apogee', $apogee)->first() ?? new Etudiant;

            $user = User::where('apogee')->orWhere('email', $email)->first() ?? new User();

            foreach ($firstRow as $cell) {
                $student->$cell = $row[$i];

                $i++;
            }


            $student->save();

            $user->name = $student->nom_fr . ' ' . $student->prenom_fr;

            $user->email = $student->email1;

            $user->apogee = $student->apogee;

            $user->password =  $student->apogee;

            $user->save();

            $student->user_id = $user->id;

            $student->save();

            $user->assignRole('student');
        }
    }
}*/
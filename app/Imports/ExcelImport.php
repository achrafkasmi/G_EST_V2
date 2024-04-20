<?php

namespace App\Imports;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 360);

        $expectedHeaders = ['apogee', 'email1', 'cne', 'nom_ar', 'nom_fr', 'prenom_ar', 'prenom_fr', 'cin', 'id_dip', 'sexe', 'pays_naissance'];//id_dip haydo o dir f blasto id li jay men t_etape_diplome

        $firstRow = null;

        if (!$rows->isEmpty()) {
            $firstRow = $rows->first()->toArray();
            $hasExpectedHeaders = true;
        } else {
            return;
        }

        if ($hasExpectedHeaders) {
            $rows = $rows->slice(1);
        }

        foreach ($rows as $row) {
            $apogee = $row[0];
            $email = $row[1];

            $student = Etudiant::where('apogee', $apogee)->first() ?? new Etudiant;

            $user = User::where('apogee', $apogee)->orWhere('email', $email)->first() ?? new User();

            foreach ($expectedHeaders as $key => $header) {
                $student->{$header} = $row[$key];
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
        }
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

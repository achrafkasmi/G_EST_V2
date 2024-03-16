<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {


        $expectedHeaders = ['cin', 'cne', 'nom_ar', 'nom', 'prenm_ar', 'prenom', 'date_naissance', 'apogee', 'email'];

        if (!empty($rows) && is_array($rows[0])) {
            
            $firstRow = $rows[0];

            $hasExpectedHeaders = true;
            
            foreach ($expectedHeaders as $header) {

                if (!in_array($header, $firstRow)) {
                    $hasExpectedHeaders = false;
                    break;
                }
            }

            if ($hasExpectedHeaders) {
             

                for ($i = 1; $i < count($rows); $i++) {

                    dd($rows[$i]);

                    $row = $rows[$i];
                }

            } else {
              

            }
        } else {
          
        }
    }
}

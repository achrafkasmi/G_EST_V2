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

        if (!$rows->isEmpty()) {
            $firstRow = $rows->first()->toArray(); // Get the first row as an associative array
        
            $hasExpectedHeaders = true;
        
            foreach ($expectedHeaders as $header) {
                // Check if the header is present in the associative array
                if (!array_key_exists($header, $firstRow)) {
                    dd('here');
                    $hasExpectedHeaders = false;
                    break;
                }
            }
        
            if ($hasExpectedHeaders) {
                foreach ($rows as $row) {
                    dd($row);
                    // Process each row
                }
            } else {
                // Handle the case where expected headers are missing
            }
        } else {
            // Handle the case where $rows is empty
        }
        
}
}

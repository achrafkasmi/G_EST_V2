<?php

namespace App\Imports;

use App\Models\ElementPedagogique;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ElementPedagogiqueImport implements ToCollection
{
    /**
     * @param Collection $collection
     * @return array
     */
    public function collection(Collection $rows)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 1000);

        $expectedHeaders = [
            'code_etape', 'id_etape', 'type_etape_element', 'intitule_element',
            'nbr_heures_cours', 'nbr_heures_td', 'nbr_heures_tp', 'nbr_heures_ap',
            'nbr_heures_evaluation', 'decription_module', 'coefficient'
        ];

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
                $elementPedagogique = new ElementPedagogique;

                foreach ($expectedHeaders as $header) {
                    $elementPedagogique->{$header} = $row[$headerMap[$header]];
                }

                $elementPedagogique->save();
            } catch (\Exception $e) {
                return ['status' => 'error', 'message' => 'Error processing row: ' . $e->getMessage()];
            }
        }

        return ['status' => 'success', 'message' => 'Data imported successfully.'];
    }
}

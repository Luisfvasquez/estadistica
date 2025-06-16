<?php

namespace App\Imports;

use App\Models\Analyte;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AnalyteImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $date_start;
    protected $date_end;
    public function __construct($date_start, $date_end)
    {
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }


    public function model(array $row)
    {
        return new Analyte([
            'group' => $row['grupo'],
            'totexa1' => $row['totexa1'],
            'descrip' => $row['descrip'],
            'idcodigo' => $row['idcodigo'],
            'totexa' => $row['totexa'],
            'sede' => $row['sede'],
            'convenio' => $row['convenio'],
            'totexa2' => $row['totexa2'],
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,            
        ]);
    }
}

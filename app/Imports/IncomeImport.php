<?php

namespace App\Imports;

use App\Models\Income;
use Maatwebsite\Excel\Concerns\ToModel;

class IncomeImport implements ToModel
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
        return new Income([
            'group' => $row['grupo'],
            'cost' => $row['costo'],
            'idcode' => $row['idcodigo'],
            'descrip' => $row['descrip'],
            'cost1' => $row['costo1'],
            'sede' => $row['sede'],
            'convenio' => $row['convenio'],
            'cost2' => $row['costo2'],
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,            
        ]);
         
    }
}

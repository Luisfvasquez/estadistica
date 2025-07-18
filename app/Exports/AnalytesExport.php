<?php

namespace App\Exports;

use App\Models\Analyte;
use Maatwebsite\Excel\Concerns\FromCollection;

class AnalytesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Analyte::all();
    }
}

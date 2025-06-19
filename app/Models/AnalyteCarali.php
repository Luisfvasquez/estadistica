<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyteCarali extends Model
{
    protected $table = 'carali_analytes';
    protected $fillable = [
        'group',
        'totexa1',
        'idcodigo',
        'descrip',
        'totexa',
        'sede',
        'convenio',
        'totexa2',
        'date_start',
        'date_end'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyteLeones extends Model
{
    protected $table = 'leones_analytes';
    
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyteSalle extends Model
{
    protected $table = 'salle_analytes';
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

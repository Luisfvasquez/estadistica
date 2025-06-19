<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeSalle extends Model
{
    protected $table = 'salle_incomes';

    
   protected $fillable = [
        'group',
        'cost',
        'idcode',
        'descrip',
        'cost1',
        'sede',
        'convenio',
        'cost2',
        'date_start',
        'date_end'
    ];
}

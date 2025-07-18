<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait AggregatesIncomes
{
     public function getGroupedCostTotals(Builder $query)
    {
        return $query->select('group', DB::raw('SUM(cost1) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->get();
    }

    public function getExamCostTotals(Builder $query)
    {
        return $query->select('Descrip', DB::raw('SUM(cost1) as total'))
            ->groupBy('Descrip')
            ->orderBy('Descrip', 'asc')
            ->get();
            
    }
}

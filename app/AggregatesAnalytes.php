<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait AggregatesAnalytes
{
    public function getGroupedTotals(Builder $query)
    {
        return $query->select('group', DB::raw('SUM(totexa) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->get();
    }

    public function getExamTotals(Builder $query)
    {
        return $query->select('Descrip', DB::raw('SUM(totexa) as total'))
            ->groupBy('Descrip')
            ->orderBy('Descrip', 'asc')
            ->get();
    }
}

<?php

namespace App;

use Illuminate\Http\Request;

trait QueryFilters
{
     public function applyDateFilters($query, Request $request)
    {
        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }
        
        return $query;
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Models\Analyte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyteController extends Controller
{   
    public function principal(Request $request)
    {
        $query = Analyte::query();


        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }

        $total = $query->sum('totexa');
        $resultados = $query->get();
        
        $grupos = $query->select('group', DB::raw('SUM(totexa) as total'))
        ->groupBy('group')
        ->orderBy('group', 'asc')
        ->get();
        
        
        
        $examenes = $query->select('Descrip', DB::raw('SUM(totexa) as total'))
        ->groupBy('Descrip')
        ->orderBy('Descrip', 'asc')
        ->get();        

        return view('analytes.principal', compact('resultados', 'grupos', 'examenes', 'total'));
    }

}

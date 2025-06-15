<?php

namespace App\Http\Controllers;

use App\Imports\AnalyteImport;
use App\Models\Analyte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AnalyteController extends Controller
{
     public function carali()
    {
        $grupos = Analyte::select('group', DB::raw('COUNT(*) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->where('sede', 'BRICENO CARALI')
            ->get(); 
            $resultados = Analyte::where('sede', 'BRICENO CARALI')->get();
        return view('analytes.carali', compact('resultados', 'grupos'));
    }

     public function leones()
    {
        $grupos = Analyte::select('group', DB::raw('COUNT(*) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->where('sede', 'BRICENO CARALI')
            ->get(); 
            $resultados = Analyte::where('sede', 'BRICENO CARALI')->get();
        return view('analytes.leones', compact('resultados', 'grupos'));
    }

     public function hospital()
    {
        $grupos = Analyte::select('group', DB::raw('COUNT(*) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->where('sede', 'BRICENO CARALI')
            ->get(); 
            $resultados = Analyte::where('sede', 'BRICENO CARALI')->get();
        return view('analytes.hospital', compact('resultados', 'grupos'));
    }

     public function salle()
    {
        $grupos = Analyte::select('group', DB::raw('COUNT(*) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->where('sede', 'BRICENO CARALI')
            ->get(); 
            $resultados = Analyte::where('sede', 'BRICENO CARALI')->get();
        return view('analytes.salle', compact('resultados', 'grupos'));
    }



    public function store() {
        $file = request()->file('file');
        Excel::import(new AnalyteImport, $file);
        return redirect()->back()->with('success', 'Archivo importado correctamente.');
    }
}

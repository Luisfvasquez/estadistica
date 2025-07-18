<?php

namespace App\Http\Controllers;

use App\AggregatesAnalytes;
use App\Models\AnalyteLeones;
use App\QueryFilters;
use App\XmlTrait;
use Illuminate\Http\Request;

class EsteAnalyte extends Controller
{
    use QueryFilters, AggregatesAnalytes, XmlTrait;

      private function fetchAnalyteData(Request $request)
    {
        $query = AnalyteLeones::query();
        
        $query = $this->applyDateFilters($query, $request);

        $resultados = $query->get();
        $total = $query->sum('totexa');

        
        $grupos = $this->getGroupedTotals($query);

        $examenes = $this->getExamTotals($query);

        return compact('resultados', 'grupos', 'examenes', 'total');
    }
    
    public function este(Request $request)
    {           
        return view('analytes.este', $this->fetchAnalyteData($request));
    }

    public function store(Request $request)
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required|file|mimes:xml|max:2048', // Validar que sea un archivo XML
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ]);

        try {
            $modelName = AnalyteLeones::class;

            $this->XmlFileAnalyte($file, $modelName, $request);

            return redirect()->back()->with('success', 'Datos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }
}

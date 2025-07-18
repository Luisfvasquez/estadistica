<?php

namespace App\Http\Controllers;

use App\AggregatesAnalytes;
use App\Models\AnalyteSalle;
use App\QueryFilters;
use App\XmlTrait;
use Illuminate\Http\Request;

class SalleAnalyte extends Controller
{
    use QueryFilters, AggregatesAnalytes, XmlTrait;

    private function fetchAnalyteData(Request $request)
    {
        $query = AnalyteSalle::query();

        $query = $this->applyDateFilters($query, $request);

        $resultados = $query->get();
        $total = $query->sum('totexa');

        
        $grupos = $this->getGroupedTotals($query);

        $examenes = $this->getExamTotals($query);

        return compact('resultados', 'grupos', 'examenes', 'total');
    }
    
    public function salle(Request $request)
    {           
        return view('analytes.salle', $this->fetchAnalyteData($request));
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
            $modelName = AnalyteSalle::class;

            $this->XmlFileAnalyte($file, $modelName, $request);

            return redirect()->back()->with('success', 'Datos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }
}

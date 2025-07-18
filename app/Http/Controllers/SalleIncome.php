<?php

namespace App\Http\Controllers;

use App\AggregatesIncomes;
use App\Models\IncomeSalle;
use App\QueryFilters;
use App\XmlTrait;
use Illuminate\Http\Request;

class SalleIncome extends Controller
{
    use QueryFilters,AggregatesIncomes, XmlTrait;

     private function fetchAnalyteData(Request $request)
    {
       $query= IncomeSalle::query();

        
        $query = $this->applyDateFilters($query, $request);

        $total = $query->sum('cost1');
        $resultados = $query->get();

        
        $grupos = $this->getGroupedCostTotals($query);

        $examenes = $this->getExamCostTotals($query);


        return compact('resultados', 'grupos', 'examenes', 'total');
    }

    public function salle(Request $request)
    {        
        return view('income.salle', $this->fetchAnalyteData($request));
    }
    public function stores(Request $request)
    {
        $file = $request->file('file');

        $request->validate([
            'file' => 'required|file|mimes:xml|max:2048', // Validar que sea un archivo XML
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ]);

        try {
            $modelName = IncomeSalle::class;

            $this->XmlFileIncome($file, $modelName, $request);

            return redirect()->back()->with('success', 'Datos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }
}

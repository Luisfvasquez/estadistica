<?php

namespace App\Http\Controllers;

use App\Models\AnalyteCarali;
use App\Models\AnalyteHospital;
use App\Models\AnalyteLeones;
use App\Models\AnalyteSalle;
use App\Models\AnalyteYaritagua;
use App\QueryFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyteController extends Controller
{
    use QueryFilters;
    
    public function principal(Request $request)
    {

        $models = [
            'carali' => AnalyteCarali::class,
            'salle' => AnalyteSalle::class,
            'este' => AnalyteLeones::class,
            'hospital' => AnalyteHospital::class,
            'yaritagua' => AnalyteYaritagua::class,
        ];

        $resultados = [];
        $grupos = [];
        $examenes = [];
        $totalSedes = [];

        foreach ($models as $sede => $model) {
            $query = $this->applyDateFilters($model::query(), $request);

            // Se almacenan resultados por sede
            $totalSedes[$sede] = $query->sum('totexa');
            $resultados[$sede] = $query->get();

            $grupos[$sede] = $query->select('group', DB::raw('SUM(totexa) as total'))
                ->groupBy('group')
                ->orderBy('group', 'asc')
                ->get();

            $examenes[$sede] = $query->select('Descrip', DB::raw('SUM(totexa) as total'))
                ->groupBy('Descrip')
                ->orderBy('Descrip', 'asc')
                ->get();
        }

        $grupos = collect($grupos)
            ->flatten(1) // Une todos los arrays de cada sede en uno solo
            ->groupBy('group') // Agrupa por el nombre del grupo
            ->map(function ($items) {
                return [
                    'group' => $items->first()->group,
                    'total' => $items->sum('total'), // Suma los totales de ese grupo
                ];
            })
            ->values(); // Limpia las claves para que sea un array plano

        $examenes = collect($examenes)
            ->flatten(1)
            ->groupBy('Descrip')
            ->map(function ($items) {
                return [
                    'Descrip' => $items->first()->Descrip,
                    'total' => $items->sum('total'),
                ];
            })
            ->values();

            $resultados = collect($resultados)->flatten(1);

            $total = array_sum($totalSedes);

        return view('analytes.principal', compact('resultados', 'grupos', 'examenes', 'total'));
    }

}

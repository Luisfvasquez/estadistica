<?php

namespace App\Http\Controllers;

use App\Models\IncomeCarali;
use App\Models\IncomeHospital;
use App\Models\IncomeLeones;
use App\Models\IncomeSalle;
use App\Models\IncomeYaritagua;
use App\QueryFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PhpParser\Node\Expr\Cast\Double;

class IncomeController extends Controller
{
    use QueryFilters;

    public function principal(Request $request)
    {

        $models = [
            'carali' => IncomeCarali::class,
            'salle' => IncomeSalle::class,
            'este' => IncomeLeones::class,
            'hospital' => IncomeHospital::class,
            'yaritagua' => IncomeYaritagua::class,
        ];

        $resultados = [];
        $grupos = [];
        $examenes = [];
        $totalSedes = [];

        foreach ($models as $sede => $model) {
            $query = $this->applyDateFilters($model::query(), $request);

            // Se almacenan resultados por sede
            $totalSedes[$sede] = $query->sum('cost1');
            $resultados[$sede] = $query->get();

            $grupos[$sede] = $query->select('group', DB::raw('SUM(cost1) as total'))
                ->groupBy('group')
                ->orderBy('group', 'asc')
                ->get();

            $examenes[$sede] = $query->select('Descrip', DB::raw('SUM(cost1) as total'))
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

        return view('income.principal', compact('resultados', 'grupos', 'examenes', 'total'));
    }

}

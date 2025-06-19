<?php

namespace App\Http\Controllers;

use App\Imports\IncomeImport;
use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use PhpParser\Node\Expr\Cast\Double;

class IncomeController extends Controller
{
    private function fetchAnalyteData(Request $request, string $sede)
    {
        $query = Income::where('sede', $sede);

        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }

        $total = $query->sum('cost1');
        $resultados = $query->get();

        $grupos = $query->select('group', DB::raw('SUM(cost1) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->get();

        $examenes = $query->select('Descrip', DB::raw('SUM(cost1) as total'))
            ->groupBy('Descrip')
            ->orderBy('Descrip', 'asc')
            ->get();


        return compact('resultados', 'grupos', 'examenes', 'total');
    }

}

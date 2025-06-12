<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    public function index()
    {
        $resultado = Visit::select('fecha', DB::raw('COUNT(*) as total'), DB::raw('DAY(FECHA) as dia'))
            ->groupBy('fecha', 'dia')
            ->orderBy('fecha', 'asc')
            ->get();
            $resultados = Visit::all();

        return view('grafico', compact('resultado', 'resultados'));
    }
}

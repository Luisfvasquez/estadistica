<?php

namespace App\Http\Controllers;

use App\Imports\AnalyteImport;
use App\Models\Analyte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class AnalyteController extends Controller
{
    private function fetchAnalyteData(Request $request, string $sede)
    {
        $query = Analyte::where('sede', $sede);
        $resultados = $query->get();

        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }

        $grupos = $query->select('group', DB::raw('COUNT(*) as total'))
            ->groupBy('group')
            ->orderBy('group', 'asc')
            ->get();

        $examenes = $query->select('Descrip', DB::raw('COUNT(*) as total'))
            ->groupBy('Descrip')
            ->orderBy('Descrip', 'asc')
            ->get();


        return compact('resultados', 'grupos', 'examenes');
    }

    public function carali(Request $request)
    {
        return view('analytes.carali', $this->fetchAnalyteData($request, 'BRICENO CARALI'));
    }

    public function leones(Request $request)
    {
        return view('analytes.leones', $this->fetchAnalyteData($request, 'BRICENO ESTE'));
    }

    public function hospital(Request $request)
    {
        return view('analytes.hospital', $this->fetchAnalyteData($request, 'BRICENO Hospital'));
    }

    public function salle(Request $request)
    {
        return view('analytes.salle', $this->fetchAnalyteData($request, 'BRICENO SALLE'));
    }

    public function yaritagua(Request $request)
    {
        return view('analytes.yaritagua', $this->fetchAnalyteData($request, 'BRICENO YARITAGUA'));
    }


    public function store()
    {
        $file = request()->file('file');

        try {
            Excel::import(
                new AnalyteImport(request('date_start'), request('date_end')),
                $file
            );

            return redirect()->back()->with('success', 'Archivo importado correctamente.');
        } catch (ValidationException $e) {
            $failures = $e->failures();

            // Puedes pasar los errores a la vista
            return redirect()->back()->withErrors($failures);
        } catch (\Throwable $e) {
            // Si hubo otro tipo de error (formato de archivo, error interno, etc.)
            return redirect()->back()->with('error', 'Error al importar el archivo: ' . $e->getMessage());
        }
    }
}

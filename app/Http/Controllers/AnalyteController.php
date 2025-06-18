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


        if ($request->filled('date_start')) {
            $query->where('date_start', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->where('date_end', '<=', $request->date_end);
        }

        $resultados = $query->get();
        $total = $query->sum('totexa');

        $grupos = $query->select('group', DB::raw('SUM(totexa) as total'))
            ->groupBy('group', 'group')
            ->orderBy('group', 'asc')
            ->get();


        $examenes = $query->select('Descrip', DB::raw('COUNT(*) as total'))
            ->groupBy('Descrip')
            ->orderBy('Descrip', 'asc')
            ->get();


        return compact('resultados', 'grupos', 'examenes', 'total');
    }

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
        
        
        
        $examenes = $query->select('Descrip', DB::raw('COUNT(*) as total'))
        ->groupBy('Descrip')
        ->orderBy('Descrip', 'asc')
        ->get();
        

        if ($total == 0) {
            return redirect()->back()->with('error', 'No se encontraron datos selecciona una fecha valida.');
        }
        return view('analytes.principal', compact('resultados', 'grupos', 'examenes', 'total'));
    }

    public function carali(Request $request)
    {
        $datos = $this->fetchAnalyteData($request, 'BRICENO CARALI');

        if ($datos['total'] == 0) {
            return redirect()->back()->with('error', 'No se encontraron datos selecciona una fecha valida.');
        }

        return view('analytes.carali', $this->fetchAnalyteData($request, 'BRICENO CARALI'));
    }

    public function leones(Request $request)
    {
        $datos = $this->fetchAnalyteData($request, 'BRICENO CARALI');

        if ($datos['total'] == 0) {
            return redirect()->back()->with('error', 'No se encontraron datos selecciona una fecha valida.');
        }
        return view('analytes.leones', $this->fetchAnalyteData($request, 'BRICENO ESTE'));
    }

    public function hospital(Request $request)
    {
        $datos = $this->fetchAnalyteData($request, 'BRICENO CARALI');

        if ($datos['total'] == 0) {
            return redirect()->back()->with('error', 'No se encontraron datos selecciona una fecha valida.');
        }
        return view('analytes.hospital', $this->fetchAnalyteData($request, 'BRICENO Hospital'));
    }

    public function salle(Request $request)
    {
        $datos = $this->fetchAnalyteData($request, 'BRICENO CARALI');

        if ($datos['total'] == 0) {
            return redirect()->back()->with('error', 'No se encontraron datos selecciona una fecha valida.');
        }
        return view('analytes.salle', $this->fetchAnalyteData($request, 'BRICENO SALLE'));
    }

    public function yaritagua(Request $request)
    {
        $datos = $this->fetchAnalyteData($request, 'BRICENO CARALI');

        if ($datos['total'] == 0) {
            return redirect()->back()->with('error', 'No se encontraron datos selecciona una fecha valida.');
        }
        return view('analytes.yaritagua', $this->fetchAnalyteData($request, 'BRICENO YARITAGUA'));
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
            $xmlString = file_get_contents($file->getRealPath());
            $xmlString = mb_convert_encoding($xmlString, 'UTF-8', 'auto');


            $xml = simplexml_load_string(
                $xmlString,
                'SimpleXMLElement',
                LIBXML_NOCDATA | LIBXML_NOERROR | LIBXML_NOWARNING
            );

            if ($xml === false) {
                return redirect()->back()->with('error', 'No se pudo leer el XML.');
            }


            $json = json_encode($xml);
            $data = json_decode($json, true);


            $totexa2 = $data['table1']['@attributes']['TotExa2'] ?? null;
            $grupos = $data['table1']['table1_GRUPO_Collection']['table1_GRUPO'] ?? [];


            foreach ($grupos as $grupo) {
                $grupoName = isset($grupo['@attributes']['GRUPO']) ? $grupo['@attributes']['GRUPO'] : null;
                $totexa1 = $grupo['@attributes']['TotExa1'] ?? null;

                $detalles = $grupo['Detail_Collection']['Detail'] ?? [];

                if (isset($detalles['@attributes'])) {
                    $detalles = [$detalles];
                }

                foreach ($detalles as $detalle) {
                    $attr = $detalle['@attributes'] ?? [];

                    Analyte::create([
                        'group'     => $grupoName,
                        'totexa1'   => $totexa1,
                        'idcodigo'  => $attr['idCodigo'] ?? null,
                        'descrip'   => $attr['Descrip'] ?? null,
                        'totexa'    => $attr['TotExa'] ?? null,
                        'sede'      => $attr['SEDE'] ?? null,
                        'convenio'  => $attr['CONVENIO'] ?? null,
                        'totexa2'   => $totexa2,
                        'date_start' => $request->input('date_start'),
                        'date_end'  => $request->input('date_end'),
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Datos importados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }
}

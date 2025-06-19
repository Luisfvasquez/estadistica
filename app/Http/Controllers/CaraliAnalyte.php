<?php

namespace App\Http\Controllers;

use App\Models\AnalyteCarali;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaraliAnalyte extends Controller
{   
    private function fetchAnalyteData(Request $request)
    {
        $query = AnalyteCarali::query();


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


        $examenes = $query->select('Descrip', DB::raw('SUM(totexa) as total'))
            ->groupBy('Descrip')
            ->orderBy('Descrip', 'asc')
            ->get();

        return compact('resultados', 'grupos', 'examenes', 'total');
    }
    
    public function carali(Request $request)
    {           
        return view('analytes.carali', $this->fetchAnalyteData($request));
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

                    AnalyteCarali::create([
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

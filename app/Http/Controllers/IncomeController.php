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

    public function carali(Request $request)
    {        
        return view('income.carali', $this->fetchAnalyteData($request, 'BRICENO CARALI'));
    }

    public function leones(Request $request)
    {       
        return view('income.leones', $this->fetchAnalyteData($request, 'BRICENO ESTE'));
    }

    public function hospital(Request $request)
    {      
        return view('income.hospital', $this->fetchAnalyteData($request, 'BRICENO Hospital'));
    }

    public function salle(Request $request)
    {        
        return view('income.salle', $this->fetchAnalyteData($request, 'BRICENO SALLE'));
    }

    public function yaritagua(Request $request)
    {        
        return view('income.yaritagua', $this->fetchAnalyteData($request, 'BRICENO YARITAGUA'));
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



            $costo2 = $data['table1']['@attributes']['costo2'] ?? null;
            $grupos = $data['table1']['table1_GRUPO_Collection']['table1_GRUPO'] ?? [];

            foreach ($grupos as $grupo) {
                $grupoName = isset($grupo['@attributes']['GRUPO']) ? $grupo['@attributes']['GRUPO'] : null;
                $costo1 = $grupo['@attributes']['costo'] ?? null;

                $detalles = $grupo['Detail_Collection']['Detail'] ?? [];

                if (isset($detalles['@attributes'])) {
                    $detalles = [$detalles];
                }

                foreach ($detalles as $detalle) {
                    $attr = $detalle['@attributes'] ?? [];

                    Income::create([
                        'group'     => $grupoName,
                        'cost'   => (float) str_replace(',', '.', $costo1),
                        'idcode'  => $attr['idCodigo'],
                        'descrip'   => $attr['Descrip'],
                        'cost1'    => (float) str_replace(',', '.', $attr['costo1']),
                        'sede'      => $attr['SEDE'],
                        'convenio'  => $attr['CONVENIO'],
                        'cost2'   => (float) str_replace(',', '.', $costo2),
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
    
    public function stores(Request $request)
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



            $costo2 = $data['table1']['@attributes']['costo2'] ?? null;
            $grupos = $data['table1']['table1_GRUPO_Collection']['table1_GRUPO'] ?? [];

            foreach ($grupos as $grupo) {
                $grupoName = isset($grupo['@attributes']['GRUPO']) ? $grupo['@attributes']['GRUPO'] : null;
                $costo1 = $grupo['@attributes']['costo'] ?? null;

                $detalles = $grupo['Detail_Collection']['Detail'] ?? [];

                if (isset($detalles['@attributes'])) {
                    $detalles = [$detalles];
                }

                foreach ($detalles as $detalle) {
                    $attr = $detalle['@attributes'] ?? [];

                    Income::create([
                        'group'     => $grupoName,
                        'cost'   => (float) str_replace(',', '.', $costo1),
                        'idcode'  => $attr['idCodigo'],
                        'descrip'   => $attr['Descrip'],
                        'cost1'    => (float) str_replace(',', '.', $attr['Costo1']),
                        'sede'      => $attr['SEDE'],
                        'convenio'  => $attr['CONVENIO'],
                        'cost2'   => (float) str_replace(',', '.', $costo2),
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

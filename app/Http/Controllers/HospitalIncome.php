<?php

namespace App\Http\Controllers;

use App\AggregatesIncomes;
use App\Models\IncomeHospital;
use App\QueryFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalIncome extends Controller
{
    use QueryFilters,AggregatesIncomes;
     private function fetchAnalyteData(Request $request)
    {
       $query= IncomeHospital::query();
       
        $query = $this->applyDateFilters($query, $request);

        $total = $query->sum('cost1');
        $resultados = $query->get();

        
        $grupos = $this->getGroupedCostTotals($query);

        $examenes = $this->getExamCostTotals($query);


        return compact('resultados', 'grupos', 'examenes', 'total');
    }

    public function hospital(Request $request)
    {        
        return view('income.hospital', $this->fetchAnalyteData($request));
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

                    IncomeHospital::create([
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

<?php

namespace App;

use Illuminate\Http\Request;

trait XmlTrait
{
    public function XmlFileAnalyte($file, $modelName, Request $request )
    {
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

                    $modelName::create([
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
    }
    public function XmlFileIncome($file, $modelName, Request $request )
    {
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

                    $modelName::create([
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
    }
}

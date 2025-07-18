<?php

namespace App\Http\Controllers;

use App\Exports\AnalyteCaraliExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportCaraliController extends Controller
{
    public function export(Request $request)
    {
        $rawData = json_decode($request->input('exportData'), true);

        // Filtrar grupos y detalles vacíos
        $filteredData = array_filter($rawData, function ($grupo) {
            // Verificar que tenga un nombre de grupo válido y al menos un detalle válido
            if (empty($grupo['grupo']) || !is_array($grupo['detalles']) || count($grupo['detalles']) === 0) {
                return false;
            }

            // Filtrar detalles vacíos dentro de cada grupo
            $grupo['detalles'] = array_filter(
                $grupo['detalles'],
                function ($detalle) {
                    return is_array($detalle) &&
                        isset($detalle['codigo'], $detalle['descripcion'], $detalle['cantidad'], $detalle['sede'], $detalle['convenio']) &&
                        !empty($detalle['codigo']);
                }
            );

            // Asegurar que queden detalles válidos luego del filtro
            return count($grupo['detalles']) > 0;
        });

        // Reindexar los arrays para evitar saltos en los índices
        $cleanedData = array_values(
            array_map(
                function ($grupo) {
            $grupo['detalles'] = array_values($grupo['detalles']);
            return $grupo;
        }, $filteredData)
    );

        return Excel::download(new AnalyteCaraliExport($cleanedData), 'carali.xlsx');
    }
}

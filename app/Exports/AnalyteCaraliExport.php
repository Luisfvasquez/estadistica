<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class AnalyteCaraliExport implements FromArray, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct(public $data) {}
    public function array(): array
    {        
        $exportData = [];

        foreach ($this->data as $grupo) {
            $exportData[] = [
                'Grupo' => $grupo['grupo'],
                'Código' => '',
                'Descripción' => '',
                'Cantidad' => '',
                'Sede' => '',
                'Convenio' => ''
            ];

            foreach ($grupo['detalles'] as $detalle) {
                // Validar que sea un array y que tenga todas las claves necesarias
                if (!is_array($detalle) || !isset($detalle['codigo'], $detalle['descripcion'], $detalle['cantidad'], $detalle['sede'], $detalle['convenio'])) {
                    continue; // saltar si está incompleto
                }

                $exportData[] = [
                    'Grupo' => '',
                    'Código' => $detalle['codigo'],
                    'Descripción' => $detalle['descripcion'],
                    'Cantidad' => $detalle['cantidad'],
                    'Sede' => $detalle['sede'],
                    'Convenio' => $detalle['convenio']
                ];
            }
        }

        return $exportData;
    }

    public function headings(): array
    {
        return ['Grupo', 'Codigo', 'Descripcion', 'Cantidad', 'Sede', 'Convenio'];
    }

    public function title(): string
    {
        return 'Examenes Agrupados';
    }
}

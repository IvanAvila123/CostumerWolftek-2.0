<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ventas;

    public function __construct($ventas)
    {
        $this->ventas = $ventas;
    }

    public function collection()
    {
        return $this->ventas;
    }

    public function map($venta): array
    {
        $lineas = '';
        if (in_array($venta->venta, ['Renovacion', 'Renovacion Anticipada T-1', 'Renovacion Anticipada'])) {
            $lineas = $venta->lineas->pluck('dn')->implode(', ');
        }

        return [
            $venta->vendedor,
            $venta->venta,
            $venta->autorizada,
            $venta->estado,
            Carbon::parse($venta->actualizacion)->format('d-m-Y'),
            $lineas,
            $venta->acuerdo,
        ];
    }

    public function headings(): array
    {
        return [
            'Vendedor',
            'Tipo de Venta',
            'Persona Autorizada',
            'Estado',
            'Fecha de Entrega',
            'Líneas (DNs)',
            'Acuerdo',
        ];
    }
}
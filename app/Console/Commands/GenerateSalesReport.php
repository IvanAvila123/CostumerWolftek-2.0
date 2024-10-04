<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class GenerateSalesReport extends Command
{
    protected $signature = 'sales:generate-report';
    protected $description = 'Generate biweekly sales report';

    public function handle()
    {
        $startDate = Carbon::now()->subDays(15)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $fileName = 'ventas_' . $startDate->format('Y-m-d') . '_' . $endDate->format('Y-m-d') . '.xlsx';

        Excel::store(new SalesExport($startDate, $endDate), 'reports/' . $fileName, 'public');

        $this->info('Informe de ventas generado: ' . $fileName);
    }

    public function export()
    {
        return Excel::download(new SalesExport, 'sales_report.xlsx');
    }
}
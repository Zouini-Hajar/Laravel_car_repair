<?php

namespace App\Exports;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class VehiclesExport implements FromCollection, WithHeadings, WithStyles
{
    private $vehicles;

    public function __construct()
    {
        $this->vehicles = Vehicle::join('clients', 'client_id', '=', 'clients.id')
            ->select([DB::raw('CONCAT(clients.first_name, " ", clients.last_name) AS client'), 'make', 'model', 'year', 'license_plate', 'vin', 'fuel_type'])
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->vehicles;
    }

    public function headings(): array
    {
        return ["Client", "Make", "Model", "Year", "License Plate", 'VIN', "Fuel Type"];
    }

    public function styles(Worksheet $sheet)
    {
        // Set the width for all columns
        $sheet->getDefaultColumnDimension()->setWidth(20); // Increase the width

        // Apply array of styles to 'A1:G1' range
        $sheet->getStyle('A1:G1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FF8B5CF6',
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Get the last row number based on the count of the collection
        $lastRow = count($this->vehicles) + 1; // Add 1 because the header is in the first row

        // Apply array of styles to 'A2:G' . $lastRow range
        $sheet->getStyle('A2:G' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Apply background color to 'A2:A' . $lastRow range (ID column)
        $sheet->getStyle('A2:A' . $lastRow)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFD8B4FE',
                ],
            ],
        ]);
    }
}

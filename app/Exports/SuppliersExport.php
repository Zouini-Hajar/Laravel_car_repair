<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SuppliersExport implements FromCollection, WithHeadings, WithStyles
{
    private $suppliers;

    public function __construct()
    {
        $this->suppliers = Supplier::select(['id', 'name', 'email', 'phone_number', 'address'])
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->suppliers;
    }

    public function headings(): array
    {
        return ["#", "Name", "Email", "Phone Number", "Address"];
    }

    public function styles(Worksheet $sheet)
    {
        // Set the width for all columns
        $sheet->getDefaultColumnDimension()->setWidth(30); // Increase the width

        // Apply array of styles to 'A1:G1' range
        $sheet->getStyle('A1:E1')->applyFromArray([
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
        $lastRow = count($this->suppliers) + 1; // Add 1 because the header is in the first row

        // Apply array of styles to 'A2:G' . $lastRow range
        $sheet->getStyle('A2:E' . $lastRow)->applyFromArray([
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

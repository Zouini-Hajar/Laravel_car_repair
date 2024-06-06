<?php

namespace App\Exports;

use App\Models\SparePart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SparePartsExport implements FromCollection, WithHeadings, WithStyles
{
    private $spareparts;

    public function __construct()
    {
        $this->spareparts = SparePart::join('suppliers', 'supplier_id', '=', 'suppliers.id')
            ->select(['spareparts.id', 'spareparts.name', 'reference', 'stock', 'price', 'email'])
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->spareparts;
    }

    public function headings(): array
    {
        return ["#", "Name", "Reference", "Stock", "Price", "Supplier Email"];
    }

    public function styles(Worksheet $sheet)
    {
        // Set the width for all columns
        $sheet->getDefaultColumnDimension()->setWidth(30); // Increase the width

        // Apply array of styles to 'A1:G1' range
        $sheet->getStyle('A1:F1')->applyFromArray([
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
        $lastRow = count($this->spareparts) + 1; // Add 1 because the header is in the first row

        // Apply array of styles to 'A2:G' . $lastRow range
        $sheet->getStyle('A2:F' . $lastRow)->applyFromArray([
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

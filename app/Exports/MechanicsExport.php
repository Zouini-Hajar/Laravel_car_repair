<?php

namespace App\Exports;

use App\Models\Mechanic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MechanicsExport implements FromCollection, WithHeadings, WithStyles
{
    private $mechanics;

    public function __construct()
    {
        $this->mechanics = Mechanic::join('users', 'user_id', '=', 'users.id')
            ->select('mechanics.id', 'first_name', 'last_name', 'cin', 'address', 'phone_number', 'email', 'recruitment_date', 'salary')
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->mechanics;
    }

    public function headings(): array
    {
        return ["#", "First Name", "Last Name", "CIN", 'Address', "Phone Number", "Email", "Recruitment Date", "Salary"];
    }

    public function styles(Worksheet $sheet)
    {
        // Set the width for all columns
        $sheet->getDefaultColumnDimension()->setWidth(30); // Increase the width

        // Apply array of styles to 'A1:G1' range
        $sheet->getStyle('A1:I1')->applyFromArray([
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
        $lastRow = count($this->mechanics) + 1; // Add 1 because the header is in the first row

        // Apply array of styles to 'A2:G' . $lastRow range
        $sheet->getStyle('A2:I' . $lastRow)->applyFromArray([
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

<?php

namespace App\Imports;

use App\Models\SparePart;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SparePartsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $supplier = Supplier::where('email', $row['supplier_email'])->first();

        return new SparePart([
            'name' => $row['name'],
            'reference' => $row['reference'],
            'stock' => $row['stock'],
            'price' => $row['price'],
            'supplier_id' => $supplier->id,
        ]);
    }
}

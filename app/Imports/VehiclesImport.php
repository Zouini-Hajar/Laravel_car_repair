<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\Vehicle;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VehiclesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $client = Client::where('cin', $row['client_cin'])->first();

        return new Vehicle([
            'client_id' => $client->id,
            'make' => $row['make'],
            'model' => $row['model'],
            'year' => $row['year'],
            'fuel_type' => $row['fuel_type'],
            'vin' => $row['vin'],
            'license_plate' => $row['license_plate'],
            'status' => 'Pending'
        ]);
    }
}

<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'cin' => $row['cin'],
            'address' => $row['address'],
            'phone_number' => $row['phone_number'],
            'email' => $row['email'],
        ]);
    }
}

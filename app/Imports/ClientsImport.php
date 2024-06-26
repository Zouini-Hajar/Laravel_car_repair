<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::create([
            'username' => $row['first_name'] . ' ' . $row['last_name'],
            'email' => $row['email'],
            'password' => bcrypt($row['first_name'] . '_' . $row['last_name'] . '@@'),
            'role' => 'client'
        ]);

        return new Client([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'cin' => $row['cin'],
            'address' => $row['address'],
            'phone_number' => $row['phone_number'],
            'user_id' => $user->id
        ]);
    }
}

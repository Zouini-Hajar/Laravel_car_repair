<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Client::join('users', 'user_id', '=', 'users.id')
        ->select('clients.id', 'first_name', 'last_name', 'cin', 'address', 'phone_number', 'email')
        ->get();
    }

    public function headings(): array
    {
        return ["#", "First Name", "Last Name", "CIN", 'Address', "Phone Number", "Email"];
    }
}

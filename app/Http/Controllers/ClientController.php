<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // Show all clients
    public function index()
    {
        return view('clients.index', [
            'clients' => Client::join('users', 'users.id', '=', 'user_id')
                ->select('clients.id', 'first_name', 'last_name', 'cin', 'phone_number', 'picture')
                ->get()
        ]);
    }

    // Show single client
    public function show(Client $client)
    {
        $user = User::find($client->user_id);
        $vehicles = Vehicle::where('client_id', $client->id)->get(['id', 'make', 'model', 'license_plate', 'status']);
        return view('clients.show', [
            'client' => $client,
            'user' => $user,
            'vehicles' => $vehicles
        ]);
    }
}

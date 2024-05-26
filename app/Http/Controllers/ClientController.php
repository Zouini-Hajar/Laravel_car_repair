<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    // Show all clients
    public function index()
    {
        return view('clients.index', [
            'clients' => Client::latest('clients.created_at')
                ->join('users', 'user_id', '=', 'users.id')
                ->select('clients.id', 'first_name', 'last_name', 'cin', 'phone_number', 'picture')
                ->simplePaginate(5)
        ]);
    }

    // Show single client
    public function show(Client $client)
    {
        $vehicles = Vehicle::where('client_id', $client->id)->get(['id', 'make', 'model', 'license_plate', 'status']);
        $invoices = Invoice::where('client_id', $client->id)
            ->join('repairs', 'repairs.invoice_id', '=', 'invoices.id')
            ->join('repairs_details', 'repairs.repair_details_id' , '=', 'repairs_details.id')
            ->select('description', 'total', 'invoices.status')
            ->get();
        return view('clients.show', [
            'client' => $client,
            'user' => User::find($client->user_id),
            'vehicles' => $vehicles,
            'invoices' => $invoices
        ]);
    }

    // Show form to create new client
    public function create()
    {
        return view('clients.create');
    }

    // Store new client
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/', Rule::unique('clients', 'phone_number')],
            'cin' => ['required', 'regex:/^[A-Za-z]\d{6}$/', Rule::unique('clients', 'cin')],
            'picture' => 'nullable|image'
        ]);

        // Create a new user
        $user = User::create([
            'username' => $data['first_name'] . ' ' . $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['first_name'] . '_' . $data['last_name'] . '@@'),
            'role' => 'client',
            'picture' => $request->hasFile('picture') ?
                $request->file('picture')->store('pictures', 'public')
                : null
        ]);

        unset($data['email']);

        // Create a new client
        $client = new Client($data);
        $client->user()->associate($user);
        $client->save();


        return redirect('/clients')->with('success', 'Client created successfully!');
    }

    // Show form to edit client
    public function edit(Client $client)
    {
        return view('clients.edit', [
            'client' => $client,
            'user' => User::find($client->user_id)
        ]);
    }

    // Update client
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/'],
            'cin' => ['required', 'regex:/^[A-Za-z]\d{6}$/'],
            'picture' => 'nullable|image'
        ]);

        $user = User::find($client->user_id);
        $user->update([
            'email' => $data['email'],
            'picture' => $request->hasFile('picture') ?
                $request->file('picture')->store('pictures', 'public')
                : $user->picture
        ]);

        unset($data['email']);

        $client->update($data);

        return redirect('/clients' . '/' . $client->id)->with('success', 'Client updated successfully!');
    }

    // Delete client
    public function destroy(Client $client)
    {
        $user = User::find($client->user_id);
        if ($user) {
            $user->delete();
        }

        $client->delete();

        return redirect('/clients')->with('success', 'Client deleted successfully!');
    }
}

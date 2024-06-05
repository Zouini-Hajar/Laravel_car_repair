<?php

namespace App\Http\Controllers;

use App\Mail\RepairRequestConfirmationMail;
use App\Mail\RepairRequestMail;
use App\Mail\RepairRequestRejectionMail;
use App\Models\Client;
use App\Models\Mechanic;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RepairRequestController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'description' => 'required',
            'vehicle_id' => 'required',
            'client_id' => 'required',
        ]);

        $admin_email = User::where('role', 'admin')->first()->email;

        Mail::to($admin_email)->send(new RepairRequestMail([
            'date' => $data['date'],
            'time' => $data['time'],
            'description' => $data['description'],
            'client' => Client::find($data['client_id']),
            'vehicle' => Vehicle::find($data['vehicle_id']),
        ]));

        return redirect('/vehicles' . '/' . $data['vehicle_id'])->with('success', 'Email sent successfully!');
    }

    public function confirm(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'vehicle_id' => 'required',
            'client_id' => 'required',
        ]);

        $client = Client::find($data['client_id']);
        $user = User::find($client->user_id);

        Mail::to($user->email)->send(new RepairRequestConfirmationMail([
            'date' => $data['date'],
            'time' => $data['time'],
            'client' => $client,
        ]));

        return view('meetings.create', [
            'data' => $data,
            'mechanics' => Mechanic::all()
        ]);
    }

    public function reject(Request $request)
    {
        $client = Client::find($request->client_id);
        $user = User::find($client->user_id);

        Mail::to($user->email)->send(new RepairRequestRejectionMail([
            'client' => $client,
        ]));

        return redirect('/')->with('success', 'Meeting rejected.');
    }
}

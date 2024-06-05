<?php

namespace App\Http\Controllers;

use App\Mail\MechanicMeetingMail;
use App\Models\Client;
use App\Models\Mechanic;
use App\Models\Meeting;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    // show all meetings
    public function index()
    {
        if (auth()->user()->role == 'client') {
            $meetings = Meeting::where('client_id', auth()->user()->client->id)
                ->join('mechanics', 'mechanic_id', '=', 'mechanics.id')
                ->select('meetings.id', DB::raw('CONCAT(mechanics.first_name, " ", mechanics.last_name) AS mechanic'), 'date', 'time', 'status')
                ->simplePaginate(5);
        } elseif (auth()->user()->role == 'mechanic') {
            $meetings = Meeting::where('mechanic_id', auth()->user()->mechanic->id)
                ->join('clients', 'client_id', '=', 'clients.id')
                ->select('meetings.id', DB::raw('CONCAT(clients.first_name, " ", clients.last_name) AS client'), 'date', 'time', 'status')
                ->simplePaginate(5);
        } else {
            $meetings = Meeting::latest('meetings.updated_at')
                ->join('mechanics', 'mechanic_id', '=', 'mechanics.id')
                ->join('clients', 'client_id', '=', 'clients.id')
                ->select('meetings.id', DB::raw('CONCAT(mechanics.first_name, " ", mechanics.last_name) AS mechanic'), DB::raw('CONCAT(clients.first_name, " ", clients.last_name) AS client'), 'date', 'time', 'status')
                ->simplePaginate(5);
        }

        return view('meetings.index', [
            'meetings' => $meetings
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required',
            'time' => 'required',
            'vehicle_id' => 'required',
            'client_id' => 'required',
            'mechanic_id' => 'required',
        ]);

        $data['date'] = Carbon::createFromFormat('m/d/Y', $data['date'])->format('Y-m-d');
        $data['status'] = 'Planned';

        $meeting = new Meeting($data);
        $meeting->save();

        $mechanic = Mechanic::find($data['mechanic_id']);
        $user = User::find($mechanic->user_id);

        Mail::to($user->email)->send(new MechanicMeetingMail([
            'date' => $data['date'],
            'time' => $data['time'],
            'vehicle' => Vehicle::find($data['vehicle_id']),
            'client' => Client::find($data['client_id']),
            'mechanic' => $mechanic
        ]));

        return redirect('/')->with('success', 'Meeting confirmed and created!');
    }
}

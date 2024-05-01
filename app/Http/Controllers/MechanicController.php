<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

class MechanicController extends Controller
{
    // Show all mechanics
    public function index()
    {
        return view('mechanics.index', [
            'mechanics' => Mechanic::join('users', 'users.id', '=', 'user_id')
                ->select('mechanics.id', 'first_name', 'last_name', 'cin', 'phone_number', 'picture')
                ->get()
        ]);
    }

    // Show single mechanic
    public function show(Mechanic $mechanic)
    {
        return view('mechanics.show', [
            'mechanic' => $mechanic
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    // show single repair
    public function show(Repair $repair) {
        $mechanic = Mechanic::find($repair->mechanic_id);
        $user = User::find($mechanic->user_id);
        $spareparts = Repair::join('repair_spareparts', 'repairs.id', '=', 'repair_id')
            ->join('spareparts', 'spareparts.id', '=', 'sparepart_id')
            ->where('repair_id', $repair->id)
            ->select('spareparts.id', 'name', 'reference', 'quantity', 'spareparts.price', 'picture')
            ->get();
        return view('repairs.show', [
            'repair' => $repair,
            'mechanic' => $mechanic,
            'user' => $user,
            'spareparts' => $spareparts
        ]);
    }
}

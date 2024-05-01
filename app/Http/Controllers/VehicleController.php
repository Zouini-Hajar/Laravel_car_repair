<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Show all vehicles
    public function index() {
        return view('vehicles.index', [
            'vehicles' => Vehicle::all(['make', 'model', 'year', 'license_plate', 'vin', 'fuel_type'])
        ]);
    }

    // Show single vehicle
    public function show(Vehicle $vehicle) {
        return view('vehicles.show', [
            'vehicle' => $vehicle
        ]);
    }
}

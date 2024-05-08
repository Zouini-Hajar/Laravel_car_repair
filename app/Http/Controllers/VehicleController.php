<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Repair;
use App\Models\Vehicle;
use Illuminate\Foundation\Console\VendorPublishCommand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    // Show all vehicles
    public function index()
    {
        return view('vehicles.index', [
            'vehicles' => Vehicle::latest()
                ->select(['id', 'make', 'model', 'year', 'license_plate', 'vin', 'fuel_type'])
                ->simplePaginate(5)
        ]);
    }

    // Show single vehicle
    public function show(Vehicle $vehicle)
    {
        $repairs = Repair::where('vehicle_id', $vehicle->id)->get(['id', 'description', 'price', 'status']);
        return view('vehicles.show', [
            'vehicle' => $vehicle,
            'repairs' => $repairs
        ]);
    }

    // Show form to create new vehicle
    public function create()
    {
        return view('vehicles.create', [
            'clients' => Client::all()
        ]);
    }

    // Store new vehicle
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'fuel_type' => 'required',
            'vin' => ['required', 'regex:/^[A-HJ-NPR-Z0-9]{17}$/', Rule::unique('vehicles', 'vin')],
            'license_plate' => ['required', Rule::unique('vehicles', 'license_plate')],
        ]);

        $data['status'] = 'Pending';

        $vehicle = new Vehicle($data);
        $vehicle->save();

        return redirect('/vehicles')->with('success', 'Vehicle created successfully!');
    }

    // Show form to edit vehicle
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', [
            'vehicle' => $vehicle,
            'clients' => Client::all()
        ]);
    }

    // Update vehicle
    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'client_id' => 'required',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'fuel_type' => 'required',
            'vin' => ['required', 'regex:/^[A-HJ-NPR-Z0-9]{17}$/'],
            'license_plate' => 'required',
        ]);

        $vehicle->update($data);

        return redirect('/vehicles')->with('success', 'Vehicle updated successfully!');
    }

    // Delete vehicle
    public function destroy()
    {
    }
}

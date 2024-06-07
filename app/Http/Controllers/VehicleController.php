<?php

namespace App\Http\Controllers;

use App\Exports\VehiclesExport;
use App\Imports\VehiclesImport;
use App\Models\Client;
use App\Models\Mechanic;
use App\Models\Repair;
use App\Models\RepairDetails;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class VehicleController extends Controller
{
    // Show all vehicles
    public function index()
    {
        if (auth()->user()->role == 'client') {
            $vehicles = Vehicle::join('clients', 'client_id', '=', 'clients.id')
                ->select(['vehicles.id', 'make', 'model', 'year', 'license_plate', 'vin', 'fuel_type'])
                ->where('client_id', auth()->user()->client->id)
                ->orderBy('vehicles.updated_at')
                ->simplePaginate(5);
        } else {
            $vehicles = Vehicle::latest()
                ->select(['id', 'make', 'model', 'year', 'license_plate', 'vin', 'fuel_type'])
                ->simplePaginate(5);
        }

        return view('vehicles.index', [
            'vehicles' => $vehicles
        ]);
    }

    // Show single vehicle
    public function show(Vehicle $vehicle)
    {
        $repairs = Repair::join('repairs_details', 'repairs.repair_details_id', '=', 'repairs_details.id')
            ->where('repairs.vehicle_id', $vehicle->id)
            ->select('repairs.id', 'description', 'price', 'status')
            ->get();

        return view('vehicles.show', [
            'vehicle' => $vehicle,
            'repairs' => $repairs,
            'repairs_details' => RepairDetails::all(),
            'mechanics' => Mechanic::all()
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
            'vin' => ['regex:/^[A-HJ-NPR-Z0-9]{17}$/', Rule::unique('vehicles', 'vin')],
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
        if ($request->hasFile('picture')) {
            $vehicle->picture =  $request->file('picture')->store('pictures', 'public');

            $vehicle->save();

            return back()->with('success', 'Image added successfully!');
        }

        $data = $request->validate([
            'client_id' => 'required',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'fuel_type' => 'required',
            'vin' => ['required', 'regex:/^[A-HJ-NPR-Z0-9]{17}$/'],
        ]);

        $vehicle->update($data);

        return redirect('/vehicles')->with('success', 'Vehicle updated successfully!');
    }

    // Delete vehicle
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect('/vehicles')->with('success', 'Vehicle deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $vehicles = Vehicle::where('make', 'LIKE', "%$query%")
            ->orWhere('model', 'LIKE', "%$query%")
            ->orWhere('year', 'LIKE', "%$query%")
            ->orWhere('license_plate', 'LIKE', "%$query%")
            ->orWhere('vin', 'LIKE', "%$query%")
            ->orWhere('fuel_type', 'LIKE', "%$query%")
            ->select(['id', 'make', 'model', 'year', 'license_plate', 'vin', 'fuel_type'])
            ->simplePaginate(5);

        $html = view('partials._table_body', [
            'list' => $vehicles,
            'columns' => !$vehicles->isEmpty() ? array_keys($vehicles->first()->toArray()) : [],
            'route' => 'vehicles'
        ])->render();

        return response()->json(['html' => $html]);
    }

    public function export()
    {
        return Excel::download(new VehiclesExport, 'vehicles.xlsx');
    }

    public function import()
    {
        Excel::import(new VehiclesImport, request()->file('file'));
        return back()->with('success', 'File imported successfully!');
    }
}

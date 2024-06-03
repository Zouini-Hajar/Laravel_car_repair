<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Mechanic;
use App\Models\Repair;
use App\Models\RepairDetails;
use App\Models\Sparepart;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RepairController extends Controller
{
    // show all repairs details
    public function index()
    {
        $repairs = Repair::latest('repairs.updated_at')
            ->join('repairs_details', 'repair_details_id', '=', 'repairs_details.id')
            ->where('repairs.mechanic_id', auth()->user()->mechanic->id)
            ->select('repairs.id', 'description', 'status', 'start_date', 'end_date')
            ->simplePaginate(5);

        return view('repairs.index', [
            'repairs' => $repairs,
            'mechanics' => Mechanic::all(),
        ]);
    }

    // show single vehicle repair
    public function show(Repair $repair)
    {
        $mechanic = Mechanic::find($repair->mechanic_id);
        $user = User::find($mechanic->user_id);

        $repair_details = Repair::join('repairs_details', 'repair_details_id', '=', 'repairs_details.id')
            ->where('repairs.id', $repair->id)
            ->select('repairs.id', 'description', 'price', 'status')
            ->first();

        $repair_details['mechanic_notes'] = $repair->mechanic_notes;

        $spareparts = Repair::join('repair_spareparts', 'repairs.id', '=', 'repair_id')
            ->join('spareparts', 'spareparts.id', '=', 'sparepart_id')
            ->where('repair_id', $repair->id)
            ->select('spareparts.id', 'name', 'reference', 'quantity', 'spareparts.price', 'picture')
            ->get();

        return view('repairs.show', [
            'repair' => $repair_details,
            'mechanic' => $mechanic,
            'user' => $user,
            'spareparts' => $spareparts,
            'spareparts_list' => Sparepart::all(),
            'mechanics' => Mechanic::all(),
        ]);
    }

    // Store new repair
    public function store(Request $request)
    {
        $data = $request->validate([
            'repair_details_id' => 'required',
            'mechanic_id' => 'required',
            'vehicle_id' => 'required',
            'status' => 'required',
            'start_date' => 'required|date',
            //'end_date' => 'date',
        ]);

        $invoice = Invoice::create([
            'client_id' => Vehicle::find($data['vehicle_id'])->client_id,
            'total' => RepairDetails::find($data['repair_details_id'])->price,
            'status' => 'Not Paid'
        ]);

        $invoice->save();

        $data['invoice_id'] = $invoice->id;
        $data['start_date'] = Carbon::createFromFormat('m/d/Y', $data['start_date'])->format('Y-m-d');

        $repair = new Repair($data);
        $repair->save();

        return redirect('/vehicles' . '/' . $data['vehicle_id'])->with('success', 'Repair added successfully!');
    }

    // Update new repair
    public function update(Request $request, Repair $repair)
    {
        if ($request->has('mechanic_notes')) {
            $data = $request->validate([
                'mechanic_notes' => 'required|string',
            ]);
        } else {
            $data = $request->validate([
                'mechanic_id' => 'required',
                'status' => 'required',
                'start_date' => 'required|date',
                //'end_date' => 'date',
            ]);

            $data['start_date'] = Carbon::createFromFormat('m/d/Y', $data['start_date'])->format('Y-m-d');
        }

        $repair->update($data);

        return redirect('/repairs' . '/' . $repair->id)->with('success', 'Repair updated successfully!');
    }

    // Delete repair
    public function destroy(Repair $repair)
    {
        $repair->delete();
        Invoice::find($repair->invoice_id)->delete();
        return redirect('/vehicles' . '/' . $repair->vehicle_id)->with('success', 'Repair deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\RepairDetails;
use Illuminate\Http\Request;

class RepairDetailsController extends Controller
{
    // show all repairs details
    public function index()
    {
        return view('repair-details.index', [
            'repairs' => RepairDetails::latest()
                ->select(['id', 'description', 'price'])
                ->simplePaginate(5)
        ]);
    }

    // Store repair details
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $repair_details = new RepairDetails($data);
        $repair_details->save();

        return redirect('/repair-details')->with('success', 'Repair created successfully!');
    }

    // Update repair details
    public function update(Request $request, RepairDetails $repair_detail)
    {
        $data = $request->validate([
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        $repair_detail->update($data);

        return redirect('/repair-details')->with('success', 'Repair updated successfully!');
    }

    // Delete supplier
    public function destroy(RepairDetails $repair_detail)
    {
        $repair_detail->delete();
        return redirect('/repair-details')->with('success', 'Repair deleted successfully!');
    }
}

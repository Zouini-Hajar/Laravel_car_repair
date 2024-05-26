<?php

namespace App\Http\Controllers;

use App\Models\RepairSparePart;
use Illuminate\Http\Request;

class RepairSparePartController extends Controller
{
    // Store sparepart of repair
    public function store(Request $request)
    {
        $data = $request->validate([
            'sparepart_id' => 'required',
            'repair_id' => 'required',
            'quantity' => 'required|numeric',
        ]);

        $repair_sparepart = new RepairSparePart($data);
        $repair_sparepart->save();

        return redirect('/repairs' . '/' . $data['repair_id'])->with('success', 'Spare part added successfully!');
    }

    // Store sparepart of repair
    public function update(Request $request, RepairSparePart $repair_sparepart)
    {
        $data = $request->validate([
            'quantity' => 'required|numeric|min:0',
        ]);

        $repair_sparepart->update($data);

        return redirect('/repairs' . '/' . $repair_sparepart->repair_id)->with('success', 'Quantity updated successfully!');
    }

    // Delete sparepart of repair
    public function destroy(RepairSparePart $repair_sparepart) {
        $repair_sparepart->delete();
        return redirect('/repairs' . '/' . $repair_sparepart->repair_id)->with('success', 'Spare part deleted successfully!');
    }
}

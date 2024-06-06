<?php

namespace App\Http\Controllers;

use App\Exports\SparePartsExport;
use App\Imports\SparePartsImport;
use App\Models\Sparepart;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SparePartController extends Controller
{
    // Show all spare parts
    public function index()
    {
        return view('spareparts.index', [
            'spareparts' => Sparepart::latest()
                ->select(['id', 'name', 'reference', 'stock', 'price', 'picture', 'supplier_id'])
                ->simplePaginate(5),
            'suppliers' => Supplier::all(['id', 'name'])
        ]);
    }

    // Store spare part
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'reference' => ['required', Rule::unique('spareparts', 'reference')],
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'picture' => 'nullable|image',
            'supplier_id' => 'required'
        ]);

        $data['picture'] = $request->hasFile('picture') ?
            $request->file('picture')->store('pictures', 'public')
            : null;

        $sparepart = new Sparepart($data);
        $sparepart->save();

        return redirect('/spareparts')->with('success', 'Spare part created successfully!');
    }

    // Update spare part
    public function update(Request $request, Sparepart $sparepart)
    {
        $data = $request->validate([
            'name' => 'required',
            'reference' => 'required',
            'stock' => 'required|numeric',
            'price' => 'required|numeric',
            'picture' => 'nullable|image',
            'supplier_id' => 'required'
        ]);

        $data['picture'] = $request->hasFile('picture') ?
            $request->file('picture')->store('pictures', 'public')
            : null;

        $sparepart->update($data);

        return redirect('/spareparts')->with('success', 'Sparepart updated successfully!');
    }

    // Delete Sparepart
    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        return redirect('/spareparts')->with('success', 'Vehicle deleted successfully!');
    }

    public function export()
    {
        return Excel::download(new SparePartsExport, 'spareparts.xlsx');
    }

    public function import()
    {
        Excel::import(new SparePartsImport, request()->file('file'));
        return back()->with('success', 'File imported successfully!');
    }
}

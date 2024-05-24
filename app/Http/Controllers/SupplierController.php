<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    // Show all suppliers
    public function index()
    {
        return view('suppliers.index', [
            'suppliers' => Supplier::latest()
                ->select(['id', 'name', 'email', 'phone_number', 'address'])
                ->simplePaginate(5)
        ]);
    }

    // Store supplier
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email:rfc,dns', Rule::unique('suppliers', 'email')],
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/', Rule::unique('suppliers', 'phone_number')],
            'address' => 'required',
        ]);

        $supplier = new Supplier($data);
        $supplier->save();

        return redirect('/suppliers')->with('success', 'Supplier created successfully!');
    }

    // Update supplier
    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone_number' => ['required', 'regex:/^(?:\+212|0)([5-7]\d{8})$/'],
            'address' => 'required',
        ]);

        $supplier->update($data);

        return redirect('/suppliers')->with('success', 'Supplier updated successfully!');
    }

    // Delete supplier
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect('/suppliers')->with('success', 'Supplier deleted successfully!');
    }
}

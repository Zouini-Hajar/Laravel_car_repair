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
            'suppliers' => Supplier::select(['id', 'name', 'email', 'phone_number', 'address'])
                ->simplePaginate(5)
        ]);
    }

    // Show single supplier
    public function show(Supplier $supplier)
    {
        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }

    // Show form to create new supplier
    public function create()
    {
        return view('suppliers.create');
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

    // Show form to edit supplier
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', [
            'supplier' => $supplier
        ]);
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
    public function destroy()
    {

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Show all suppliers
    public function index() {
        return view('suppliers.index', [
            'suppliers' => Supplier::all(['id', 'name', 'email', 'phone_number', 'address'])
        ]);
    }

    // Show single supplier
    public function show(Supplier $supplier) {
        return view('suppliers.show', [
            'supplier' => $supplier
        ]);
    }
}

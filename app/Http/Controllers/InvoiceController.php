<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Repair;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Show all invoices
    public function index()
    {
        if (auth()->user()->role == 'client') {
            $invoices = Repair::join('invoices', 'invoices.id', '=', 'invoice_id')
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->join('users', 'user_id', '=', 'users.id')
                ->where('user_id', auth()->user()->id)
                ->select('invoices.id as id', 'repairs.id as repair_id', 'first_name', 'last_name', 'total', 'invoices.status')
                ->simplePaginate(5);
        } else {
            $invoices = Repair::join('invoices', 'invoices.id', '=', 'invoice_id')
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->select('invoices.id as id', 'repairs.id as repair_id', 'first_name', 'last_name', 'total', 'invoices.status')
                ->simplePaginate(5);
        }

        return view('invoices.index', [
            'invoices' => $invoices
        ]);
    }

    // Update invoice
    public function update(Request $request, Invoice $invoice)
    {
        $status = $request->validate([
            'status' => 'required'
        ]);

        $invoice->update($status);

        return redirect('/invoices')->with('success', 'Invoice updated successfully!');
    }
}

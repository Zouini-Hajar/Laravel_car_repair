<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Repair;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Show all invoices
    public function index()
    {
        $invoices = Repair::join('invoices', 'invoices.id', '=', 'invoice_id')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->select('invoices.id as id', 'repairs.id as repair_id', 'first_name', 'last_name', 'total', 'invoices.status')
            ->get();
        return view('invoices.index', [
            'invoices' => $invoices
        ]);
    }
}

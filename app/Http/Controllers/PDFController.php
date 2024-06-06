<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Repair;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        $data = Invoice::join('clients', 'client_id', '=', 'clients.id')
            ->join('users', 'user_id', '=', 'users.id')
            ->join('repairs', 'invoice_id', '=', 'invoices.id')
            ->where('invoices.id', $id)
            ->select('invoices.id as id', DB::raw('CONCAT(first_name, " ", last_name) AS full_name'), 'address', 'email', 'total', 'repairs.id as repair_id')
            ->first();


        $repair = Repair::join('repairs_details', 'repair_details_id', '=', 'repairs_details.id')
            ->where('repairs.id', $data['repair_id'])
            ->select('description', 'price')
            ->first();

        $spareparts = Repair::join('repair_spareparts', 'repairs.id', '=', 'repair_id')
            ->join('spareparts', 'spareparts.id', '=', 'sparepart_id')
            ->where('repair_id', $data['repair_id'])
            ->select('name', 'quantity', 'spareparts.price as price')
            ->get();


        $pdf = Pdf::loadView('pdf.invoice', [
            'data' => $data,
            'repair' => $repair,
            'spareparts' => $spareparts
        ]);

        return $pdf->download('invoice.pdf');
    }
}

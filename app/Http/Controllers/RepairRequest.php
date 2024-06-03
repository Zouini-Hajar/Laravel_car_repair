<?php

namespace App\Http\Controllers;

use App\Mail\RepairRequestConfirmationMail;
use App\Mail\RepairRequestMail;
use App\Mail\RepairRequestRejectionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RepairRequest extends Controller
{
    public function submitRequest(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'meeting_date' => 'required|date',
            'description' => 'required|string',
        ]);

        // Send an email to the admin
        Mail::to('zouinihajar1@gmail.com')->send(new RepairRequestMail($validated));
    }

    public function confirm($subject, $meeting_date, $description)
    {
        Mail::to('client@example.com')->send(new RepairRequestConfirmationMail(compact('subject', 'meeting_date', 'description'), 'confirmed'));
    }

    public function reject($subject, $meeting_date, $description)
    {
        Mail::to('client@example.com')->send(new RepairRequestRejectionMail(compact('subject', 'meeting_date', 'description'), 'rejected'));
    }
}

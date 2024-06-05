<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepairRequestRejectionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        return $this->data = $data;
    }

    public function build()
    {
        return $this->view('emails.reject-repair')
            ->subject('Meeting Update')
            ->with([
                'data' => $this->data,
            ]);
    }
}

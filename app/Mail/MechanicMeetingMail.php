<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MechanicMeetingMail extends Mailable
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
        return $this->view('emails.mechanic-meeting')
            ->subject('New Meeting awaits')
            ->with([
                'data' => $this->data,
            ]);
    }
}

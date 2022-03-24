<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactInfo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($_contactInfo)
    {
        $this->contactInfo = $_contactInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nuovo contatto da ' . $this->contactInfo->name)->view('mails.newContact');
    }
}

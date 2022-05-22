<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PassportDecision extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name, $passportNumber, $decision;
    public function __construct($name, $passportNumber, $decision)
    {
        $this->name = $name;
        $this->passportNumber = $passportNumber;
        $this->decision = $decision;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.passport_decision', ['name' => $this->name, 'passportNumber' => $this->passportNumber, 'decision' => $this->decision]);
    }
}

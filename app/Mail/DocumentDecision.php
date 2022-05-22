<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentDecision extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name, $documentName, $decision;
    public function __construct($name, $documentName, $decision)
    {
        $this->name = $name;
        $this->documentName = $documentName;
        $this->decision = $decision;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.document_decision', ['name' => $this->name, 'documentName' => $this->documentName, 'decision' => $this->decision]);
    }
}

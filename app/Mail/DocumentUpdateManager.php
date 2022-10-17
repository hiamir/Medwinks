<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DocumentUpdateManager extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name, $clientName, $documentName;
    public function __construct($name, $clientName,$documentName)
    {
        $this->name = $name;
        $this->documentName = $documentName;
        $this->clientName=$clientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.document_update_manager', ['name' => $this->name, 'clientName'=>$this->clientName,'documentName' => $this->documentName])->subject($this->clientName. ' updated document');
    }
}

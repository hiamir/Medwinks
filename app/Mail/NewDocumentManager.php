<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewDocumentManager extends Mailable
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name, $documentType, $decision;
    public function __construct($name, $documentType)
    {
        $this->name = $name;
        $this->documentType = $documentType;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.new_document_manager', ['name' => $this->name, 'documentType' => $this->documentType])->subject('New document from '.$this->name);;
    }
}

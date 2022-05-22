<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdditionalDocumentsRequired extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name, $serviceName, $requirements;
    public function __construct($name, $serviceName, $requirements)
    {
        $this->name = $name;
        $this->serviceName = $serviceName;
        $this->requirements = $requirements;

    }

    /**
     * Build the message.
     *
     * @return
     */
    public function build()
    {
        return $this->markdown('mail.additional_documents_required', ['name' => $this->name, 'serviceName' => $this->serviceName, 'requirements' => $this->requirements]);
    }
}

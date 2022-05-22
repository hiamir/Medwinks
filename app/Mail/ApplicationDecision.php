<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ApplicationDecision  extends Mailable
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name, $serviceName, $decision;
    public function __construct($name, $serviceName, $decision)
    {
        $this->name = $name;
        $this->serviceName = $serviceName;
        $this->decision = $decision;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.application_decision', ['name' => $this->name, 'serviceName' => $this->serviceName, 'decision' => $this->decision]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PassportUpdateManager extends Mailable
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $name, $clientName, $passportName;
    public function __construct($name, $clientName,$passportName)
    {
        $this->name = $name;
        $this->passportName = $passportName;
        $this->clientName=$clientName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.passport_update_manager', ['name' => $this->name, 'clientName'=>$this->clientName,'passportName' => $this->passportName])->subject($this->clientName. ' updated passport');
    }
}

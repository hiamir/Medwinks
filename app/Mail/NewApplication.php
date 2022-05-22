<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewApplication extends Mailable
{
    use Queueable, SerializesModels;

    public $name,$serviceName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$serviceName)
    {
        $this->name=$name;
        $this->serviceName=$serviceName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.new-application',['name'=>$this->name,'serviceName'=>$this->serviceName]);
    }
}

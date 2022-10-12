<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewApplicationManager extends Mailable
{
    use Queueable, SerializesModels;

    public $name,$serviceName,$manager_name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($manager_name,$name,$serviceName)
    {
        $this->manager_name=$manager_name;
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
        return $this->markdown('mail.new-application-manager',['manager_name'=>$this->manager_name,'name'=>$this->name,'serviceName'=>$this->serviceName])->subject('New application from '.$this->name);
    }
}

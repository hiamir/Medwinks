<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TwoFactor extends Mailable
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name, $code,$requestCode;
    public function __construct($name,$code,$requestCode=null)
    {
        $this->name=$name;
        $this->code=$code;
        $this->requestCode=$requestCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.two_factor',['name'=>$this->name,'code'=>$this->code]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable 
{
    use Queueable, SerializesModels;

    
    public $name, $subject, $email;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$name,$email)
    {
        $this->subject = $subject;
        $this->name    = $name;
        $this->email   = $email;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.welcome-mail', [
                'name'  => $this->name,
                'email' => $this->email
            ])->subject($this->subject);
    }
}

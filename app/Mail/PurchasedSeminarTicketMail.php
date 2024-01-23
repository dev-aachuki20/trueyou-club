<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchasedSeminarTicketMail extends Mailable 
{
    use Queueable, SerializesModels;

    public $name, $subject, $email,$seminar;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$name,$email,$seminar)
    {
        $this->subject = $subject;
        $this->name    = $name;
        $this->email   = $email;
        $this->seminar = $seminar;

    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.purchased-seminar-ticket-mail', [
                'name'  => $this->name,
                'email' => $this->email,
                'seminar' => $this->seminar,
            ])->subject($this->subject);
    }
}

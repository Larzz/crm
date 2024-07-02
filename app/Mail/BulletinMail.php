<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulletinMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $user, $title, $message;
    public function __construct($user, $title, $message)
    {
        $this->user = $user;
        $this->message = $message;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)
            ->markdown('mail.bulletin-mail')
            ->with([
            'message' => $this->message,
            'user' => $this->user
        ]);
    }
}

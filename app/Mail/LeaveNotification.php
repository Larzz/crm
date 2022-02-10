<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $leave, $user, $message, $subject;

    public function __construct($leave, $user, $message, $subject)
    {
        $this->leave = $leave;
        $this->user = $user;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.leave-notification')
                ->subject($this->subject)
                ->from('sender@creativouae.com', 'Creativo Backend')
                ->with([
                    'leave' => $this->leave, 
                    'user' => $this->user, 
                    'message' => $this->message, 
                    'subject' => $this->subject
                ]);
    }
}

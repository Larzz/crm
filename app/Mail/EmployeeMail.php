<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user, $leave, $subject, $password;

    public function __construct($user, $leave, $password, $subject)
    {
        $this->user = $user;
        $this->leave = $leave;
        $this->password = $password;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.employee')
                ->subject($this->subject)
                ->from('sender@creativouae.com', 'Creativo Backend')
                ->with([
                    'user' => $this->user,
                    'leave' => $this->leave,
                    'password' => $this->password,
                    'subject' => $this->subject
                ]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $client, $password, $subject;
    
    public function __construct($client, $password, $subject)
    {
        $this->client = $client;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.client-notification')
                    ->subject($this->subject)
                    ->from('sender@creativouae.com', 'Creativo Backend')
                    ->with([
                        'user' => $this->client,
                        'password' => $this->password,
                        'subject' => $this->subject
                    ]);
    }
}

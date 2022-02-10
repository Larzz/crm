<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $date_from, $date_to, $employee, $total_days, $remaining_days;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $employee, $subject)
    {
        $this->date_from = $data->date_from;
        $this->date_to = $data->date_to;
        $this->total_days = $data->total_days;
        $this->remaining_days  = $data->remaining_days;
        $this->subject = $subject;
        $this->employee = $employee;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.leavemail')->subject($this->subject)
            ->from('sender@creativouae.com', 'Creativo Backend')
            ->with([
                'date_from' => $this->date_from,
                'date_to' => $this->date_to,
                'total_days'=> $this->total_days,
                'remaining_days' => $this->remaining_days,
                'employee' => $this->employee
        ]);
     }
}

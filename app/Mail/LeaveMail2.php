<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveMail2 extends Mailable
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
        $this->leave_from = $data->leave_from;
        $this->leave_to = $data->leave_to;
        $this->total_days = $data->number_of_day;
        $this->remaining_days  = $data->balance;
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
        return $this->view('emails.leavemail2')->subject($this->subject)
            ->from('sender@creativouae.com', 'Creativo Backend')
            ->with([
                'subject' => $this->subject,
                'date_from' => $this->leave_from,
                'date_to' => $this->leave_to,
                'total_days'=> $this->total_days,
                'remaining_days' => $this->remaining_days,
                'employee' => $this->employee
        ]);
     }
}

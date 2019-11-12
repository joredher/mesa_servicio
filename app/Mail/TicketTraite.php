<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketTraite extends Mailable
{
    use Queueable, SerializesModels;
    protected $ticket;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ticket)
    {
        $this->ticket=$ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $ticket=$this->ticket;
        return $this->view('mail.tickettraite', compact('ticket'))
           ->subject('Servicio terminado');
    }
}

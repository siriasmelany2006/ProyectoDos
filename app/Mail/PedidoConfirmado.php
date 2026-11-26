<?php

namespace App\Mail;

use App\Models\Pedido;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PedidoConfirmado extends Mailable
{
    public function __construct(public Pedido $pedido)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Confirmación de tu pedido #' . $this->pedido->id_pedido . ' - CrickoStore');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.pedido-confirmado');
    }
}

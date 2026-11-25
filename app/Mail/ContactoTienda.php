<?php

namespace App\Mail;

use App\Models\Tienda;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactoTienda extends Mailable
{
    public function __construct(public Tienda $tienda, public array $datos)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo mensaje para ' . $this->tienda->nombre . ' desde CrickoStore',
            // Al responder, le llega directo al cliente que escribió
            replyTo: [new Address($this->datos['correo'], $this->datos['nombre'])],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contacto');
    }
}

<?php

namespace App\Mail;

use App\Models\Cuota;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable para enviar la factura de una cuota al cliente.
 *
 * @author Victor
 * @version 1.0
 */
class FacturaCuota extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Cuota La cuota de la que se genera la factura */
    public Cuota $cuota;

    /**
     * Constructor del mailable.
     */
    public function __construct(Cuota $cuota)
    {
        $this->cuota = $cuota;
    }

    /**
     * Asunto del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Factura Nº ' . str_pad($this->cuota->id, 6, '0', STR_PAD_LEFT) . ' - Nosecaen S.L.',
        );
    }

    /**
     * Contenido del correo.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.factura-cuota',
        );
    }

    /**
     * Adjunta el PDF de la factura al correo.
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('cuotas.factura', ['cuota' => $this->cuota]);

        return [
            Attachment::fromData(
                fn () => $pdf->output(),
                'factura-' . str_pad($this->cuota->id, 6, '0', STR_PAD_LEFT) . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}

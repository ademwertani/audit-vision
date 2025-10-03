<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuoteSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public Quote $quote;
    public string $pdfBinary;

    public function __construct(Quote $quote, string $pdfBinary)
    {
        $this->quote = $quote;
        $this->pdfBinary = $pdfBinary;
    }

    public function build()
    {
        return $this->subject('Nouvelle demande de devis #'.$this->quote->id)
            ->view('emails.quote_submitted') // corps HTML de l’email
            ->attachData(
                $this->pdfBinary,
                'demande-devis-'.$this->quote->id.'.pdf',
                ['mime' => 'application/pdf']
            );
    }
}

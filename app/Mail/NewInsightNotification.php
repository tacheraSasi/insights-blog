<?php

namespace App\Mail;

use App\Models\Insight;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewInsightNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Insight $insight
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Insight: ' . $this->insight->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-insight',
        );
    }
}
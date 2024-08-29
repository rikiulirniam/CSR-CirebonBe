<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // Menyimpan data user yang dikirimkan ke view

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user; // Menyimpan data user ke properti class
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.email', // Nama view yang digunakan untuk email
            with: [
                'verificationUrl' => $this->generateVerificationUrl(), // Mengirimkan URL verifikasi ke view
            ]
        );
    }

    /**
     * Generate the verification URL.
     */
    protected function generateVerificationUrl()
    {
        return url('/verify-email/' . $this->user->verification_token);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

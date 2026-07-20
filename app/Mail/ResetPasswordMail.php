<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public readonly User $user,
        public readonly string $token,
        public readonly ?string $resetLink = null,
    )
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.Auth.ResetPasswordMail',
            with: [
                'user' => $this->user,
                'token' => $this->token,
                'resetLink' => $this->resetLink ?? $this->generateDefaultResetLink()
            ]
        );
    }

    private function generateDefaultResetLink(): string
    {
        return route('user.reset-password',
        ['token' => $this->token,
        'email' => $this->user->email]);
    }
}

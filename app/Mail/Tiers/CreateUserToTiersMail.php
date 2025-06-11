<?php

namespace App\Mail\Tiers;

use App\Models\Core\Company;
use App\Models\Tiers\Tiers;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateUserToTiersMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Company $company,
        public User $user,
        public string $password,
        public string $url_access_panel,
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->company->name." - Création de votre compte d'accès",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.create-user-to-tiers',
            with: [
                'url_access_panel' => $this->url_access_panel,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

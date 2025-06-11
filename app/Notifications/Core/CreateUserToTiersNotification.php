<?php

namespace App\Notifications\Core;

use App\Models\Core\Company;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateUserToTiersNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public User $user,
        public string $password
    )
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $company = Company::first();
        return (new MailMessage)
            ->success()
            ->markdown('emails.create-user-to-tiers', [
                'company' => $company,
                'user' => $this->user,
                'password' => $this->password,
                'url_access_panel' => route('auth.activate', ['token' => $this->user->token])
            ]);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}

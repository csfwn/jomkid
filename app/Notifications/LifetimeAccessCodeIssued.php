<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LifetimeAccessCodeIssued extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $code,
        private readonly string $customerName,
        private readonly int $amountSen,
        private readonly string $packageName,
    ) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kod pendaftaran JomKid anda')
            ->greeting('Hai '.$this->customerName.',')
            ->line('Pembayaran '.number_format($this->amountSen / 100, 2).' MYR untuk '.$this->packageName.' telah disahkan.')
            ->line('Ini ialah kod pendaftaran JomKid sekali guna:')
            ->line($this->code)
            ->action('Daftar akaun JomKid', url('/register?code='.urlencode($this->code)))
            ->line('Kod ini hanya boleh digunakan sekali dan perlu digunakan bersama alamat e-mel pembelian ini.')
            ->line('Jangan kongsikan kod ini dengan orang lain.');
    }
}

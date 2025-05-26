<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class toERM extends Notification
{
    use Queueable;
    public $offerData;
    /**
     * Create a new notification instance.
     */
    public function __construct($offerData)
    {
        $this->offerData = $offerData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting($this->offerData['greeting'])
            ->subject($this->offerData['subject'])
            ->line($this->offerData['line'])
            ->line($this->offerData['line2'])
            ->action('View Report', url($this->offerData['actionUrl']))
            ->line($this->offerData['line3']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [

            'greeting' => $this->offerData['greeting'],
            'subject' => $this->offerData['subject'],
            'line' => $this->offerData['line'],
            'line2' => $this->offerData['line2'],
            'url' => $this->offerData['actionUrl'],
            'line3' => $this->offerData['line3']

        ];
    }
}

<?php
declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

/**
 * Represents a notification sent for password reset.
 */
class ResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('email.reset.subject'))
            ->greeting(__('email.greeting'))
            ->line(__('email.reset.description'))
            ->action(
                __('email.reset.action'),
                $this->resetUrl($notifiable)
            )
            ->line(
                Lang::get(
                    __('email.reset.warning'),
                    [
                        'count' => config(
                            'auth.passwords.'.config(
                                'auth.defaults.passwords'
                            ).'.expire'
                        ),
                    ]
                )
            )
            ->salutation(__('email.salutation'));
    }

    protected function resetUrl(mixed $notifiable): string
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));
    }
}

<?php
declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Represents a notification sent when a user's account details change.
 */
class UserAccountChangedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
            ->subject(__('email.account_change.subject'))
            ->greeting(__('email.greeting'))
            ->line(__('email.account_change.description'))
            ->line(__('email.account_change.new_details'))
            ->line(
                __('email.account_change.role').': '.$notifiable->role->name
            )
            ->line(
                __('email.account_change.department').': '.$notifiable->department->name
            )
            ->line(
                __('email.account_change.post').': '.$notifiable->post
            )
            ->salutation(__('email.salutation'));
    }
}

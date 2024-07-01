<?php

namespace App\Notifications;

use App\Models\RepairApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Represents a notification sent when the status of a repair application changes.
 */
class RepairApplicationStatusChangedNotification extends Notification
{
    use Queueable;

    private RepairApplication $repairApplication;

    /**
     * Create a new notification instance.
     */
    public function __construct(RepairApplication $repairApplication)
    {
        $this->repairApplication = $repairApplication;
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
            ->subject(__('email.repair_application_status_change.subject'))
            ->greeting(__('email.greeting'))
            ->line(__('email.repair_application_status_change.description'))
            ->line(__('email.repair_application_status_change.new_details'))
            ->line(
                __('email.repair_application_status_change.number') . ': ' . $this->repairApplication->id
            )
            ->line(
                __('email.repair_application_status_change.short_description') . ': ' . $this->repairApplication->short_description
            )
            ->line(
                __('email.repair_application_status_change.status') . ': ' . $this->repairApplication->status->name
            )
            ->salutation(__('email.salutation'));
    }
}

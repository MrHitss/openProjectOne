<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\SlackMessage;

class FilesNotification extends Notification
{
    use Queueable;

    public $dependency;

    /**
     * Create a new notification instance.
     */
    public function __construct($dependency)
    {
        $this->dependency = $dependency;
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
                    ->line('We wanted to inform you that the status of your file has been updated.')
                    ->line('Current Status: '.$this->dependency->status_name)
                    ->line('Thank you for using our application!');
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
                ->to('#opentext-slack-testing')
                ->text('We wanted to inform you that the status of your file has been updated.');

    }       
    
    public function routeNotificationForSlack()
    {
        return 'https://hooks.slack.com/services/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';
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

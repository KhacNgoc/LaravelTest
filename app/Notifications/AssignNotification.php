<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $t, $status)
    {
        $this->task = $t;
        $this->status = $status;
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
        switch ($this->status) {
            case 'assign':
                return (new MailMessage)
                    ->line('You have been assigned the task:')
                    ->line('ID: ' . $this->task->id)
                    ->line('Title: ' . $this->task->title)
                    ->line('Content: ' . $this->task->content)
                    ->line('Status: ' . $this->task->status)
                    ->line('Thank you!');
            case 'change':
                return (new MailMessage)
                    ->line('Your job status has been changed:')
                    ->line('ID: ' . $this->task->id)
                    ->line('Title: ' . $this->task->title)
                    ->line('Content: ' . $this->task->content)
                    ->line('Status: ' . $this->task->status)
                    ->line('Thank you!');
        }
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

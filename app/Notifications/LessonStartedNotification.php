<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;


class LessonStartedNotification extends Notification implements ShouldQueue
{
     use Queueable;

    public $lesson;

    public function __construct($lesson)
    {
        $this->lesson = $lesson;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'lesson_id' => $this->lesson->id,
            'title' => $this->lesson->title,
            'message' => 'تم بدء الدرس الآن',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'lesson_id' => $this->lesson->id,
            'title' => $this->lesson->title,
            'message' => 'تم بدء الدرس الآن',
        ]);
    }
}

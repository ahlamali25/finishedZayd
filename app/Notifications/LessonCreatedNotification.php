<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class LessonCreatedNotification extends Notification implements ShouldQueue
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
            'message' => 'تم إضافة درس جديد',
            'date' => $this->lesson->date ?? null,
            'time' => $this->lesson->time ?? null,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'lesson_id' => $this->lesson->id,
            'title' => $this->lesson->title,
            'message' => 'تم إضافة درس جديد',
            'date' => $this->lesson->date ?? null,
            'time' => $this->lesson->time ?? null,
        ]);
    }
}

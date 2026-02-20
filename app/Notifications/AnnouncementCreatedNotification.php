<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AnnouncementCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $announcement;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'announcement_id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'message' => 'تم إضافة إعلان جديد',
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'announcement_id' => $this->announcement->id,
            'title' => $this->announcement->title,
            'message' => 'تم إضافة إعلان جديد',
        ]);
    }
}

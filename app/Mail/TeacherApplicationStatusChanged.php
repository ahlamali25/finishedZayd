<?php

namespace App\Mail;

use App\Models\TeacherApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherApplicationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $status;

    public function __construct(TeacherApplication $application, string $status)
    {
        $this->application = $application;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'approved' ? 'تم قبول طلب التدريس' : 'تم رفض طلب التدريس';

        return $this->subject($subject)
                    ->view('emails.teacher_application_status')
                    ->with([
                        'application' => $this->application,
                        'status' => $this->status,
                    ]);
    }
}

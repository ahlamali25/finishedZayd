<?php

namespace App\Mail;

use App\Models\TeacherApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct(TeacherApplication $application)
    {
        $this->application = $application;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('طلب تدريس جديد')
                    ->view('emails.teacher_application_submitted')
                    ->with(['application' => $this->application]);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;

class JobApplied extends Mailable
{
    use Queueable, SerializesModels;

    public $job;

    /**
     * Create a new message instance.
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Lấy công việc từ đối tượng $this->job
        $job = $this->job;

        // Lấy công ty từ công việc
        $company = $job->users;


        // Kiểm tra xem công ty tồn tại và có email không

            return $this->from('your_email@example.com', 'Your Name')
                ->subject('Custom Subject')
                ->view('emails.job_applied')
                ->with([
                    'jobTitle' => $job->title,
                    'userName' => Auth::user()->name,
                ]);
        }


}

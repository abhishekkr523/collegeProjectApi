<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\IssueMail;

class SendIssueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student_parent_email;
    protected $sender;
    protected $issue;
    protected $subject;

    /**
     * Create a new job instance.
     */
    public function __construct($student_parent_email, $sender, $issue, $subject)
    {
        $this->student_parent_email = $student_parent_email;
        $this->sender = $sender;
        $this->issue = $issue;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->student_parent_email)
            ->send(new IssueMail($this->sender, $this->issue, $this->subject));
    }
}

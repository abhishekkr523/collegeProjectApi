<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IssueMail extends Mailable
{
    use Queueable, SerializesModels;
    public $subject;
    public $issue;
    public $sender;
    /**
     * Create a new message instance.
     */
    public function __construct($subject, $issue,$sender)
    {
        $this->issue = $issue;
        $this->subject=$subject;
        $this->sender=$sender;
    }

    public function build()
    {
        return $this->subject("{$this->subject}")
                    ->html("
                        <h3>Notification</h3>
                        <p>{$this->issue}</p>
                        <p>Regards</p>
                        <p>GECJ</p>
                    ");
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: '{$this->subject}',
    //     );
    // }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

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
    public $studentName;
    public $bookName;
    public $issueDate;
    public $returnDate;
    public $fine;
    public $customText;
    /**
     * Create a new message instance.
     */
    public function __construct( $customText, $subject)
    {
        $this->customText = $customText;
        $this->subject=$subject;
    }

    public function build()
    {
        return $this->subject("{$this->subject}")
                    ->html("
                        <h1>Notification</h1>
                        <p>{$this->customText}</p>
                        <p>Regards,</p>
                        <p>GECJ</p>
                        <p>Your Library Team</p>
                    ");
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Issue Mail',
        );
    }

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

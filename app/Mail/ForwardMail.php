<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForwardMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /** @var Message $message */
    private Message $message;

    /**
     * ForwardMail constructor.
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return ForwardMail
     */
    public function build() : self
    {
        return $this
            ->to($this->message->alias->message_forward_to)
            ->subject($this->message->subject)
            ->replyTo($this->message->from_email)
            ->view('emails.forward')
            ->text($this->message->body_plain)
            ->with([
                'email' => $this->message,
            ])
        ;
    }
}

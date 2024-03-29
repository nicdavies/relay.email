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
        $subject = sprintf(
            '%s - fwrd from %s',
            $this->message->subject,
            config('app.name')
        );

        $mail = $this
            ->to($this->message->alias->message_forward_to)
            ->subject($subject)
            ->replyTo($this->message->from_email, $this->message->from_name)
        ;

        if ($this->message->body_html) {
            $mail->view('emails.forward', [
                'email' => $this->message,
            ]);
        }

        if ($this->message->body_plain) {
            $mail->text('emails.forward_plain', [
                'email' => $this->message,
            ]);
        }

        return $mail;
    }
}

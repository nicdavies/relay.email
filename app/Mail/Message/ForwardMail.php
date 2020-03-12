<?php

namespace App\Mail\Message;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForwardMail extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    private Request $request;

    private Message $message;

    /**
     * Create a new message instance.
     * @param Request $request
     * @param Message $message
     */
    public function __construct(Request $request, Message $message)
    {
        $this->request = $request;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        /** @var Mailable $mail */
        $mail = $this
            ->replyTo($this->message->from)
            ->view('view.name')
        ;

        // todo - if there's attachments, attach those!

        return $mail;
    }
}

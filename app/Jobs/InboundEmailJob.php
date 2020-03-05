<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Alias;
use App\Models\Message;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use App\Mail\Message\ForwardMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Support\Enums\MessageActionType;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Message\NewMessageNotification;

class InboundEmailJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    /** @var Request $request */
    private $request;

    /**
     * Execute the job.
     *
     * @param Request $request
     * @return void
     */
    public function handle(Request $request) : void
    {
        $this->request = $request;

        // todo - add support for custom domains as well as aliases

        // the alias looks like: frontier.nic@frontier.sh
        // where "frontier" is the name of the alias, "nic" is the user's name.
        // so, we need to get the alias before the "."
        $recipient = Str::before($request->input('recipient'), '@');

        $alias = Str::beforeLast($recipient, '.');
        $name  = Str::afterLast($recipient, '.');

        /** @var Alias|null $alias */
        $alias = Alias::whereCompleteAlias($alias, $name)
            ->first()
        ;

        if (! $alias instanceof Alias) {
            return;
        }

        switch ($alias->message_action) {
            case MessageActionType::IGNORE:
                $this->save($alias, true);
                break;

            case MessageActionType::SAVE:
                $this->save($alias);
                break;

            case MessageActionType::FORWARD:
                $this->forward($alias, true);
                break;

            case MessageActionType::FORWARD_AND_SAVE:
                $this->forwardAndSave($alias);
                break;
        }
    }

    /**
     * @param Alias $alias
     * @param bool $hidden
     * @return void
     */
    private function save(Alias $alias, bool $hidden = false) : void
    {
        /** @var Message $message */
        $message = $alias
            ->messages()
            ->create([
                'subject' => $this->request->input('subject'),
                'from' => $this->request->input('from'),
                'sender' => $this->request->input('sender'),
                'body_html' => $this->request->input('body-html'),
                'body_plain' => $this->request->input('stripped-html'),
                'attachment_count' => $this->request->input('attachment_count', 0),
                'raw_payload' => $this->request->toArray(),
                'token' => $this->request->input('token'),
                'signature' => $this->request->input('signature'),

                'is_hidden' => $hidden,

                'properties' => [
                    'in_reply_to' => $this->request->input('In-Reply-To'),
                    'message_id' => $this->request->input('Message-Id'),
                    'references' => $this->request->input('References'),
                ],
            ])
        ;

        // todo - If there's attachments, we want to save them and attach to this message
        if ($this->request->input('attachment_count') > 0) {
        }

        /** @var User $user */
        $user = $alias->user;

        // Send a notification to the user about this new message
        Notification::send($user, new NewMessageNotification($message));
    }

    /**
     * @param Alias $alias
     * @param bool $hidden
     * @return void
     */
    private function forward(Alias $alias, bool $hidden = false) : void
    {
        Mail::to($alias->message_forward_to)
            ->send(new ForwardMail($this->request))
        ;
    }

    /**
     * @param Alias $alias
     * @param bool $hidden
     * @return void
     */
    private function forwardAndSave(Alias $alias, bool $hidden = false) : void
    {
        $this->save($alias);
        $this->forward($alias);
    }
}

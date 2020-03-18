<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Alias;
use App\Models\Message;
use App\Support\Helpers\Str;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
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

        // the alias looks like: abcd.nic@relaymail.email
        // where "frontier" is the name of the alias, "nic" is the user's name.
        // so, we need to get the alias before the "."
        $recipient = Str::before($request->input('ToFull.0.Email'), '@');
        $alias     = Str::beforeLast($recipient, '.');
        $name      = Str::afterLast($recipient, '.');

        /** @var Alias|null $alias */
        $alias = Alias::whereCompleteAlias($alias, $name)->first();

        if (! $alias instanceof Alias) {
            return;
        }

        switch ($alias->message_action->key) {
            case MessageActionType::IGNORE:
                $this->save($alias, true);
                break;

            case MessageActionType::SAVE:
                $this->save($alias);
                break;

            case MessageActionType::FORWARD:
                $this->save($alias, true);
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
                'message_id' => $this->request->input('MessageID'),
                'subject' => $this->request->input('Subject'),
                'from_name' => $this->request->input('FromFull.Name'),
                'from_email' => $this->request->input('FromFull.Email'),
                'body_html' => $this->request->input('HtmlBody'),
                'body_plain' => $this->request->input('TextBody'),
                'attachment_count' => $this->request->input('attachment_count', 0),
                'raw_payload' => $this->request->toArray(),
                'intro_line' => Str::words($this->request->input('TextBody', ''), 8),
//                'spam_score' => $this->request->input(''),

                'is_hidden' => $hidden,
                'properties' => $this->request->input('Headers'),
            ])
        ;

        // If there's attachments, we want to save them and attach to this message
        if (count($this->request->input('Attachments', [])) > 0) {
            collect($this->request->input('Attachments'))->each(function ($item) use ($message) {
                if (array_key_exists('Content', $item)) {
                    $message
                        ->addMediaFromBase64($item['Content'])
                        ->setFileName($item['Name'])
                        ->toMediaCollection('attachments')
                    ;
                }
            });
        }

        /** @var User $user */
        $user = $alias->user;

        // Only send a notification if the message is not to be hidden!
        if (! $hidden) {
            Notification::send($user, new NewMessageNotification($message));
        }
    }

    /**
     * @param Alias $alias
     * @param bool $hidden
     * @return void
     */
    private function forward(Alias $alias, bool $hidden = false) : void
    {
        // todo - implement me!
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

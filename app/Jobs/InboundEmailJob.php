<?php

namespace App\Jobs;

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
        $recipient = Str::before($request->input('recipient'), '@');
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
                'message_id' => $this->request->input('Message-Id'),
                'subject' => $this->request->input('subject'),
                'from_name' => $this->request->input('from'),
                'from_email' => $this->request->input('sender'),
                'body_html' => $this->request->input('body-html'),
                'body_plain' => $this->request->input('body-plain'),
                'attachment_count' => $this->request->input('attachment_count', 0),
                'intro_line' => Str::words($this->request->input('body-plain', ''), 8),

                'is_hidden' => $hidden,
                'properties' => [],
                'raw_payload' => $this->request->toArray(),
            ])
        ;

        // If there's attachments, we want to save them and attach to this message
        if (count($this->request->input('attachment-count ', 0)) > 0) {
            $attachments = json_decode($this->request->input('content-id-map', []), true);

            collect($attachments)->each(function ($value, $key) use ($message) {
                $message
                    ->addMediaFromUrl($value)
                    ->toMediaCollection('attachments')
                ;
            });
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

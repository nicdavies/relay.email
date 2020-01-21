<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReEncryptMessagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var User $user */
    private User $user;

    /** @var string|null $oldKey */
    private ?string $oldKey;

    /** @var string $newKey */
    private string $newKey;

    /**
     * ReEncryptMessagesJob constructor.
     * @param User $user
     * @param string|null $oldKey
     * @param string $newKey
     */
    public function __construct(User $user, ?string $oldKey, string $newKey)
    {
        $this->user = $user;
        $this->oldKey = $oldKey;
        $this->newKey = $newKey;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() : void
    {
        // todo - grab all messages encrypted with the old key, and re-encrypt with the new key!
    }
}

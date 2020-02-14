<?php

namespace App\Events\Billing;

use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SubscribeEvent
{
    use Dispatchable;
    use SerializesModels;

    /** @var User $user */
    public $user;

    /**
     * SubscribeEvent constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

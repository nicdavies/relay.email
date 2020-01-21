<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisterEvent
{
    use Dispatchable, SerializesModels;

    /** @var Request $request */
    public $request;

    /** @var User $user */
    public $user;

    /**
     * RegisterEvent constructor.
     * @param Request $request
     * @param User $user
     */
    public function __construct(Request $request, User $user)
    {
        $this->request = $request;
        $this->user = $user;
    }
}

<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ReferralRegisterJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var Request $request */
    private $request;

    /** @var User $newUser */
    private $newUser;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @param User $newUser
     */
    public function __construct(Request $request, User $newUser)
    {
        $this->request = $request;
        $this->newUser = $newUser;
    }

    /**
     * @return void
     */
    public function handle() : void
    {

    }
}

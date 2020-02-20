<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use Spatie\Dns\Dns;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VerifyDomainJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var User $user */
    private User $user;

    /**
     * VerifyDomainJob constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $domain = $this->user->custom_domain;

        /** @var Dns $dns */
        $dns = new Dns($domain);

        try {
            $records = $dns->getRecords(['TXT', 'MX']);
        } catch (Exception $e) {
        }

        // todo - check that there's a TXT record with the key "relaymail-app-code"
        // todo - check that the value exists in the users table
        // todo - then check the mx records are set up

        $this->user->update([
            'custom_domain_verified_at' => Carbon::now(),
        ]);
    }
}

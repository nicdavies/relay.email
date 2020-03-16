<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use Spatie\Dns\Dns;
use App\Models\CustomDomain;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VerifyDomainJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var CustomDomain $domain */
    private CustomDomain $domain;

    /**
     * VerifyDomainJob constructor.
     * @param CustomDomain $domain
     */
    public function __construct(CustomDomain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return void
     */
    public function handle() : void
    {
        /** @var Dns $dns */
        $dns = (new Dns($this->domain->custom_domain));

        try {
            $records = $dns->getRecords('TXT', 'MX');
        } catch (Exception $e) {
        }

        if ($records === '') {
            return;
        }

        // Todo - split the dns record string into an array
        $dnsRecords = explode("\t", $records);
        dd($dnsRecords);

        // todo - have to come back to - homestead box doesn't have the DNS resolver working

        // todo - check that there's a TXT record with the key "relaymail-app-code"
        // todo - check that the value exists in the users table
        // todo - then check the mx records are set up

        $this->domain->update([
            'verified_at' => Carbon::now(),
        ]);
    }
}

<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Alias\WeeklyAliasUpdateNotification;

class WeeklyAliasUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alias:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out an email notification for updates on your aliases.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        User::whereNotSuspended()->get()->each(function ($user) {
            Notification::send($user, new WeeklyAliasUpdateNotification($user));
        });
    }
}

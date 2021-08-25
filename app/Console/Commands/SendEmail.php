<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending email to the subscribers';

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
     * @return int
     */
    public function handle()
    {
        $subscribers = DB::table('subscriptions')
            ->join('users', 'users.id', '=', 'subscriptions.user_id')
            ->select('users.name', 'users.email')
            ->get();

        foreach ($subscribers as $subscriber) {
            Mail::raw('Welcome to our community', function ($message) use ($subscriber) {
                $message->to($subscriber->email)
                ->subject('Hello '.$subscriber->name);
            });
        }

        $this->info('Email sent to all subscribers');
    }
}

<?php

namespace App\Console\Commands;

use App\Jobs\QueueJob;
use App\Models\User;
use Illuminate\Console\Command;

class DailyUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-daily-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an daily updates email to all users';

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
        //get email list
        $users = User::select('email')->get();

        //create a new array of email
        $collection = collect($users);
        $plucked  = $collection->pluck('email');
        $emails = $plucked->all();

        //dispatch
        dispatch(new QueueJob($emails));

        return 'Email send successfully';

        // return Command::SUCCESS;
    }
}

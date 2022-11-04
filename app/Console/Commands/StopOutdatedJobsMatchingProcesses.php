<?php

namespace App\Console\Commands;

use App\Job;
use App\Jobs\ProcessStopMatching;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StopOutdatedJobsMatchingProcesses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:stop-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks all outdated jobs and stops matching processes';

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
    public function handle()
    {
        $jobs = Job::query()
            ->where('draft',0)
            ->where('expiration_date','<',Carbon::now())
            ->where('matching_active',1)
            ->get();

        foreach ($jobs as $job){

            ProcessStopMatching::dispatch($job)->onQueue('stopMatches');

        }
    }
}

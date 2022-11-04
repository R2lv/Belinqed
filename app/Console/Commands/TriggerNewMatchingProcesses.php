<?php

namespace App\Console\Commands;

use App\Company;
use App\Job;
use App\Jobs\ProcessNewMatching;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TriggerNewMatchingProcesses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:new-matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks if there are new resumes matching the job and adds it to the queue';

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



        $jobs = Job::query()->with(['job_salary','company.package'])
            ->where('draft',0)
            ->where('expiration_date','>=',Carbon::now())
            ->where('matching_active',1)
            ->get();


        foreach ($jobs as $job){

            ProcessNewMatching::dispatch($job)->onQueue('newMatches');

        }





        // lets find new matches



    }
}

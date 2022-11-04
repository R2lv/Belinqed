<?php

namespace App\Jobs;

use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessStopMatching implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $jobObject;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Job $job)
    {
        $this->jobObject = $job;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // we are storing the jobs which should be matched to the database and are calling them here to add new matches

        \Log::info('Stop matching attempt of the job id '.$this->jobObject->id);


        $job = Job::query()->find($this->jobObject->id);
        $job->matching_active = 0;
        $job->save();
    }
}

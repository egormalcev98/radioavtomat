<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TodayJobs\TodayJobsService;

class TodayJobNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'today_jobs:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notify today jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $service;

    public function __construct(TodayJobsService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->service->notify();

		return true;
    }

}

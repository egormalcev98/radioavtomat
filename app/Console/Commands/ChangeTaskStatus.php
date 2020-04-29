<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Tasks\TaskService;

class ChangeTaskStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:change_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change status overdue tasks';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        parent::__construct();
        $this->taskService = $taskService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->taskService->changeTaskStatusesOnCron();
		$this->taskService->toRemind();

		return true;
    }

}

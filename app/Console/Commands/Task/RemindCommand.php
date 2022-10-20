<?php

namespace App\Console\Commands\Task;

use App\Notifications\RemindTask;
use App\Services\RemindTask\Contracts\RemindTaskServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Psy\Command\ExitCommand;

class RemindCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send tasks reminders';

    public function __construct(
        private readonly RemindTaskServiceContract $remindTaskService,
        private readonly UserServiceContract $userService
    ) {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return int
     * @throws \App\Services\ImportantTask\Exceptions\ImportantTaskTaskNotFoundException
     * @throws \App\Services\ImportantTask\Exceptions\ImportantTaskUserNotFoundException
     * @throws \App\Services\RemindTask\Exceptions\RemindTaskDeleteFailedException
     * @throws \App\Services\RemindTask\Exceptions\RemindTaskNotFoundException
     * @throws \App\Services\User\Exceptions\UserNotFoundException
     */
    public function handle()
    {
        $reminders = $this->remindTaskService->findAll();

        if (empty($reminders)) {
            $this->info('Empty');

            return ExitCommand::SUCCESS;
        }

        foreach ($reminders as $reminder) {
            $remindDate = Carbon::createFromTimestamp($reminder->date);

            if ($remindDate->greaterThan(now())) {
                continue;
            }

            $user = $this->userService->findOneByIdAsModel($reminder->userId);

            Notification::send($user, new RemindTask($reminder));

            $this->remindTaskService->delete($reminder->taskId, $reminder->userId);
        }

        $this->info('Success');

        return ExitCommand::SUCCESS;
    }
}

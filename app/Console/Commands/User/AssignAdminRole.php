<?php

namespace App\Console\Commands\User;

use App\Enums\RoleEnum;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Console\Command;
use InvalidArgumentException;
use Psy\Command\ExitCommand;
use Throwable;

class AssignAdminRole extends Command
{
    public function __construct(private UserServiceContract $userService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:assign-admin-role {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign admin role to user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $email = $this->argument('email');

            if (!$email || !is_string($email)) {
                throw new InvalidArgumentException('Missing email argument');
            }

            $this->userService->assignRoleByEmail($email, RoleEnum::ADMIN);
            $this->info('Success');

            return ExitCommand::SUCCESS;
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());

            return ExitCommand::FAILURE;
        }
    }
}

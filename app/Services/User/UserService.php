<?php

namespace App\Services\User;

use App\Enums\RoleEnum;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    public function __construct(private UserRepositoryContract $userRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function assignRoleByEmail(string $email, RoleEnum $role): void
    {
        $this->userRepository->assignRoleByEmail($email, $role);
    }
}

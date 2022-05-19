<?php

namespace App\Services\User\Repositories;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Exceptions\UserNotFoundException;

class UserRepository implements UserRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function assignRoleByEmail(string $email, RoleEnum $role): void
    {
        $user = User::firstWhere('email', $email);

        if (!$user) {
            throw new UserNotFoundException([$email]);
        }

        $user->assignRole($role->value);
    }
}

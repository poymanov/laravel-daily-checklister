<?php

namespace App\Services\User\Contracts;

use App\Enums\RoleEnum;
use App\Services\User\Exceptions\UserNotFoundException;

interface UserRepositoryContract
{
    /**
     * Назначение роли пользователю по email
     *
     * @param string   $email
     * @param RoleEnum $role
     *
     * @return void
     * @throws UserNotFoundException
     */
    public function assignRoleByEmail(string $email, RoleEnum $role): void;
}

<?php

namespace App\Services\User\Contracts;

use App\Enums\RoleEnum;
use App\Services\User\Exceptions\UserNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserServiceContract
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

    /**
     * Получение пользователей без прав администратора
     *
     * @return LengthAwarePaginator
     */
    public function findAllNotAdminLatest(): LengthAwarePaginator;
}

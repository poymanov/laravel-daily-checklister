<?php

namespace App\Services\User\Contracts;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\User\Exceptions\UserNotFoundException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * Получение пользователей без прав администратора
     *
     * @param int $paginationPerPage
     *
     * @return LengthAwarePaginator
     */
    public function findAllNotAdminLatest(int $paginationPerPage): LengthAwarePaginator;

    /**
     * Проверка существования пользователя по идентификатору
     *
     * @param int $userId
     *
     * @return bool
     */
    public function isExists(int $userId): bool;

    /**
     * Получение модели пользователя по ID
     *
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function findOneByIdAsModel(int $id): User;
}

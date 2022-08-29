<?php

namespace App\Services\User;

use App\Enums\RoleEnum;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Contracts\UserServiceContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService implements UserServiceContract
{
    public function __construct(private UserRepositoryContract $userRepository, private int $paginationPerPage)
    {
    }

    /**
     * @inheritDoc
     */
    public function assignRoleByEmail(string $email, RoleEnum $role): void
    {
        $this->userRepository->assignRoleByEmail($email, $role);
    }

    /**
     * Получение пользователей без прав администратора
     *
     * @return LengthAwarePaginator
     */
    public function findAllNotAdminLatest(): LengthAwarePaginator
    {
        return $this->userRepository->findAllNotAdminLatest($this->paginationPerPage);
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $userId): bool
    {
        return $this->userRepository->isExists($userId);
    }
}

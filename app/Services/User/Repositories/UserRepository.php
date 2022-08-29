<?php

namespace App\Services\User\Repositories;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Services\User\Contracts\UserRepositoryContract;
use App\Services\User\Exceptions\UserNotFoundException;
use App\Services\User\Factories\UserDtoFactory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * @inheritDoc
     */
    public function findAllNotAdminLatest(int $paginationPerPage): LengthAwarePaginator
    {
        return User::doesntHave('roles')->latest()->paginate($paginationPerPage)
            ->through(fn (User $user) => UserDtoFactory::createFromModel($user));
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $userId): bool
    {
        return User::whereId($userId)->exists();
    }
}

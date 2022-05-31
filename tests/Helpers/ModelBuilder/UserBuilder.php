<?php

namespace Tests\Helpers\ModelBuilder;

use App\Enums\RoleEnum;
use App\Models\User;

class UserBuilder
{
    /**
     * Создание сущности {@see User}
     *
     * @param array $params Параметры нового объекта
     *
     * @return User
     */
    public function create(array $params = []): User
    {
        return User::factory()->create($params);
    }

    /**
     * Создание сущности {@see User} с правами администратора
     *
     * @param array $params Параметры нового объекта
     *
     * @return User
     */
    public function createAdmin(array $params = []): User
    {
        $user = User::factory()->create($params);
        $user->assignRole(RoleEnum::ADMIN->value);

        return $user;
    }
}

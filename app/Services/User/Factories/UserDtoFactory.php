<?php

namespace App\Services\User\Factories;

use App\Models\User;
use App\Services\User\Dtos\UserDto;

class UserDtoFactory
{
    /**
     * @param User $user
     *
     * @return UserDto
     */
    public static function createFromModel(User $user): UserDto
    {
        $dto            = new UserDto();
        $dto->name      = $user->name;
        $dto->email     = $user->email;
        $dto->website   = $user->website;
        $dto->createdAt = $user->created_at?->toDateTime();

        return $dto;
    }
}

<?php

namespace App\Services\User\Dtos;

use DateTime;

class UserDto
{
    public string $name;

    public string $email;

    public ?string $website;

    public ?DateTime $createdAt;
}

<?php

namespace App\Services\RemindTask\Dtos;

class RemindTaskCreateDto
{
    /** @var int */
    public int $taskId;

    /** @var int */
    public int $userId;

    /** @var string */
    public string $date;

    /** @var string */
    public string $time;
}

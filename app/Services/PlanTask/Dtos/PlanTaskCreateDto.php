<?php

namespace App\Services\PlanTask\Dtos;

use DateTime;

class PlanTaskCreateDto
{
    /** @var int */
    public int $taskId;

    /** @var int */
    public int $userId;

    /** @var DateTime */
    public DateTime $date;
}

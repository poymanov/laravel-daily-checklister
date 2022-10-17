<?php

namespace App\Services\PlanTask\Dtos;

use App\Services\Checklist\Dtos\ChecklistShortDto;
use App\Services\Task\Dtos\TaskDto;
use DateTime;

class PlanTaskDto
{
    public int $id;

    public int $userId;

    public DateTime $date;

    public TaskDto $task;

    public ChecklistShortDto $checklist;
}

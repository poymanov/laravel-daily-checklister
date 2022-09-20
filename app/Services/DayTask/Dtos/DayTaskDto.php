<?php

namespace App\Services\DayTask\Dtos;

use App\Services\Checklist\Dtos\ChecklistShortDto;
use App\Services\Task\Dtos\TaskDto;

class DayTaskDto
{
    public int $id;

    public int $userId;

    public TaskDto $task;

    public ChecklistShortDto $checklist;
}

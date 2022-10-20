<?php

namespace App\Services\RemindTask\Dtos;

use App\Services\Checklist\Dtos\ChecklistShortDto;
use App\Services\Task\Dtos\TaskDto;

class RemindTaskDto
{
    /** @var int */
    public int $taskId;

    /** @var int */
    public int $userId;

    /** @var int */
    public int $date;

    /** @var TaskDto */
    public TaskDto $task;

    /** @var ChecklistShortDto */
    public ChecklistShortDto $checklist;
}

<?php

namespace App\Services\ImportantTask\Dtos;

use App\Services\Checklist\Dtos\ChecklistShortDto;
use App\Services\Task\Dtos\TaskDto;

class ImportantTaskDto
{
    public int $id;

    public int $userId;

    public TaskDto $task;

    public ChecklistShortDto $checklist;
}

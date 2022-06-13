<?php

namespace App\Services\Checklist\Dtos;

use App\Services\Task\Dtos\TaskDto;

class ChecklistDto
{
    public int $id;

    public string $name;

    public int $checklistGroupId;

    /** @var TaskDto[] */
    public array $tasks;
}

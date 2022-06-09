<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;

class TaskRepository implements TaskRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(TaskCreateDto $taskCreateDto): void
    {
        $task               = new Task();
        $task->name         = $taskCreateDto->name;
        $task->description  = $taskCreateDto->description;
        $task->checklist_id = $taskCreateDto->checklistId;

        if (!$task->save()) {
            throw new TaskCreateFailedException();
        }
    }
}

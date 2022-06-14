<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;

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

    /**
     * @inheritDoc
     */
    public function update(int $id, TaskUpdateDto $taskUpdateDto): void
    {
        $task = Task::find($id);

        if (!$task) {
            throw new TaskNotFoundException($id);
        }

        $task->name        = $taskUpdateDto->name;
        $task->description = $taskUpdateDto->description;

        if (!$task->save()) {
            throw new TaskUpdateFailedException($id);
        }
    }
}

<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
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
        $task->order        = $taskCreateDto->order;

        if (!$task->save()) {
            throw new TaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, TaskUpdateDto $taskUpdateDto): void
    {
        $task = $this->findModelById($id);

        $task->name        = $taskUpdateDto->name;
        $task->description = $taskUpdateDto->description;

        if (!$task->save()) {
            throw new TaskUpdateFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $task = $this->findModelById($id);

        if (!$task->delete()) {
            throw new TaskDeleteFailedException($id);
        }

        $checklist = $task->checklist;
        $checklist->tasks()->where('order', '>', $task->order)->decrement('order');
    }

    /**
     * Получение модели по ID
     *
     * @param int $id
     *
     * @return Task
     * @throws TaskNotFoundException
     */
    private function findModelById(int $id): Task
    {
        $task = Task::find($id);

        if (!$task) {
            throw new TaskNotFoundException($id);
        }

        return $task;
    }
}

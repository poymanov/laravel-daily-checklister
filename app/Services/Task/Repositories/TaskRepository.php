<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use App\Services\Task\Factories\TaskDtoFactory;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
     * @inheritDoc
     */
    public function findAllByChecklistId(int $checklistId): array
    {
        $tasks = Task::whereChecklistId($checklistId)->orderBy('order')->get();

        return TaskDtoFactory::createFromModelsList($tasks);
    }

    /**
     * @inheritDoc
     */
    public function changeOrder(int $id, ChangeOrderDirectionEnum $direction): void
    {
        $task = $this->findModelById($id);

        $newOrder = $direction == ChangeOrderDirectionEnum::PREV ? $task->order - 1 : $task->order + 1;

        DB::transaction(function () use ($task, $newOrder) {
            Task::where('order', $newOrder)->update(['order' => $task->order]);

            $task->order = $newOrder;
            $task->save();
        });
    }

    /**
     * @inheritDoc
     */
    public function complete(int $id, int $completedBy, string $completedAt): void
    {
        $task               = $this->findModelById($id);
        $task->completed_by = $completedBy;
        $task->completed_at = Carbon::createFromTimeString($completedAt);

        if (!$task->save()) {
            throw new Exception('Failed to complete task');
        }
    }

    /**
     * @inheritDoc
     */
    public function incomplete(int $id): void
    {
        $task               = $this->findModelById($id);
        $task->completed_by = null;
        $task->completed_at = null;

        if (!$task->save()) {
            throw new Exception('Failed to incomplete task');
        }
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $id): bool
    {
        return Task::whereId($id)->exists();
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

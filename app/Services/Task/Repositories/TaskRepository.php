<?php

namespace App\Services\Task\Repositories;

use App\Models\Task;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use App\Services\Task\Factories\TaskDtoFactory;
use Illuminate\Support\Facades\DB;
use Throwable;

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
     * Получение задач по ID чеклиста
     *
     * @param int $checklistId
     *
     * @return TaskDto[]
     */
    public function findAllByChecklistId(int $checklistId): array
    {
        $tasks = Task::whereChecklistId($checklistId)->orderBy('order')->get();

        return TaskDtoFactory::createFromModelsList($tasks);
    }

    /**
     * Изменение порядка задачи
     *
     * @param int                      $id
     * @param ChangeOrderDirectionEnum $direction
     *
     * @return void
     * @throws TaskNotFoundException
     * @throws Throwable
     */
    public function changeOrder(int $id, ChangeOrderDirectionEnum $direction): void
    {
        try {
            $task = $this->findModelById($id);
        } catch (Throwable) {
            return;
        }

        $newOrder = $direction == ChangeOrderDirectionEnum::PREV ? $task->order - 1 : $task->order + 1;

        DB::transaction(function () use ($task, $newOrder) {
            Task::where('order', $newOrder)->update(['order' => $task->order]);

            $task->order = $newOrder;
            $task->save();
        });
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

<?php

namespace App\Services\DayTask\Repositories;

use App\Models\DayTask;
use App\Services\DayTask\Contracts\DayTaskRepositoryContract;
use App\Services\DayTask\Dtos\DayTaskCreateDto;
use App\Services\DayTask\Exceptions\DayTaskCreateFailedException;
use App\Services\DayTask\Exceptions\DayTaskNotFoundException;
use App\Services\DayTask\Factories\DayTaskDtoFactory;

class DayTaskRepository implements DayTaskRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(DayTaskCreateDto $dayTaskCreateDto): void
    {
        $dayTask          = new DayTask();
        $dayTask->user_id = $dayTaskCreateDto->userId;
        $dayTask->task_id = $dayTaskCreateDto->taskId;

        if (!$dayTask->save()) {
            throw new DayTaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        $dayTasks = DayTask::with('task', 'task.checklist')->where('user_id', $userId)->get();

        return DayTaskDtoFactory::createFromModelsList($dayTasks);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $taskId, int $userId): void
    {
        $dayTask = DayTask::where(['task_id' => $taskId, 'user_id' => $userId])->first();

        if (!$dayTask) {
            throw new DayTaskNotFoundException();
        }

        if (!$dayTask->delete()) {
            throw new DayTaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $taskId, int $userId): bool
    {
        return DayTask::where(['task_id' => $taskId, 'user_id' => $userId])->exists();
    }

    /**
     * @inheritDoc
     */
    public function countByUserId(int $userId): int
    {
        return DayTask::where('user_id', $userId)->count();
    }
}

<?php

namespace App\Services\DayTask\Repositories;

use App\Models\DayTask;
use App\Services\DayTask\Contracts\DayTaskRepositoryContract;
use App\Services\DayTask\Dtos\DayTaskCreateDto;
use App\Services\DayTask\Exceptions\DayTaskCreateFailedException;
use App\Services\DayTask\Exceptions\DayTaskNotFoundException;

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
     * Удаление задачи
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws DayTaskCreateFailedException
     * @throws DayTaskNotFoundException
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
}

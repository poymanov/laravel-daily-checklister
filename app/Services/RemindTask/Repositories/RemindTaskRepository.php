<?php

namespace App\Services\RemindTask\Repositories;

use App\Models\RemindTask;
use App\Services\RemindTask\Contracts\RemindTaskRepositoryContract;
use App\Services\RemindTask\Dtos\RemindTaskCreateDto;
use App\Services\RemindTask\Dtos\RemindTaskDto;
use App\Services\RemindTask\Exceptions\RemindTaskCreateFailedException;
use App\Services\RemindTask\Exceptions\RemindTaskDeleteFailedException;
use App\Services\RemindTask\Exceptions\RemindTaskNotFoundException;
use App\Services\RemindTask\Factories\RemindTaskDtoFactory;
use Illuminate\Support\Carbon;
use Throwable;

class RemindTaskRepository implements RemindTaskRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(RemindTaskCreateDto $dto): void
    {
        $remindTask          = new RemindTask();
        $remindTask->user_id = $dto->userId;
        $remindTask->task_id = $dto->taskId;
        $remindTask->date    = Carbon::parse($dto->date . ' ' . $dto->time);

        if (!$remindTask->save()) {
            throw new RemindTaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $taskId, int $userId): void
    {
        $remindTask = $this->findOneByTaskIdAndUserIdAsModel($taskId, $userId);

        if (!$remindTask->delete()) {
            throw new RemindTaskDeleteFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?RemindTaskDto
    {
        try {
            return RemindTaskDtoFactory::createFromModel($this->findOneByTaskIdAndUserIdAsModel($taskId, $userId));
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return RemindTaskDtoFactory::createFromModelsList(RemindTask::all());
    }

    /**
     * Получение AR-объекта заметки о задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return RemindTask
     * @throws RemindTaskNotFoundException
     */
    private function findOneByTaskIdAndUserIdAsModel(int $taskId, int $userId): RemindTask
    {
        $remindTask = RemindTask::where(['user_id' => $userId, 'task_id' => $taskId])->first();

        if (!$remindTask) {
            throw new RemindTaskNotFoundException();
        }

        return $remindTask;
    }
}

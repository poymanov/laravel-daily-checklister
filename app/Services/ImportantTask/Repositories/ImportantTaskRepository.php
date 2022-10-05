<?php

namespace App\Services\ImportantTask\Repositories;

use App\Models\ImportantTask;
use App\Services\ImportantTask\Contracts\ImportantTaskRepositoryContract;
use App\Services\ImportantTask\Dtos\ImportantTaskCreateDto;
use App\Services\ImportantTask\Exceptions\ImportantTaskCreateFailedException;
use App\Services\ImportantTask\Exceptions\ImportantTaskDeleteFailedException;
use App\Services\ImportantTask\Exceptions\ImportantTaskNotFoundException;
use App\Services\ImportantTask\Factories\ImportantTaskDtoFactory;

class ImportantTaskRepository implements ImportantTaskRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(ImportantTaskCreateDto $importantTaskCreateDto): void
    {
        $importantTask          = new ImportantTask();
        $importantTask->user_id = $importantTaskCreateDto->userId;
        $importantTask->task_id = $importantTaskCreateDto->taskId;

        if (!$importantTask->save()) {
            throw new ImportantTaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $taskId, int $userId): void
    {
        $importantTask = ImportantTask::where(['task_id' => $taskId, 'user_id' => $userId])->first();

        if (!$importantTask) {
            throw new ImportantTaskNotFoundException();
        }

        if (!$importantTask->delete()) {
            throw new ImportantTaskDeleteFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        $importantTasks = ImportantTask::with('task', 'task.checklist')->where('user_id', $userId)->get();

        return ImportantTaskDtoFactory::createFromModelsList($importantTasks);
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $taskId, int $userId): bool
    {
        return ImportantTask::where(['task_id' => $taskId, 'user_id' => $userId])->exists();
    }

    /**
     * @inheritDoc
     */
    public function countByUserId(int $userId): int
    {
        return ImportantTask::where('user_id', $userId)->count();
    }
}

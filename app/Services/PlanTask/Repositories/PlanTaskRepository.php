<?php

namespace App\Services\PlanTask\Repositories;

use App\Models\PlanTask;
use App\Services\PlanTask\Contracts\PlanTaskRepositoryContract;
use App\Services\PlanTask\Dtos\PlanTaskCreateDto;
use App\Services\PlanTask\Dtos\PlanTaskDto;
use App\Services\PlanTask\Exceptions\PlanTaskCreateFailedException;
use App\Services\PlanTask\Exceptions\PlanTaskDeleteFailedException;
use App\Services\PlanTask\Exceptions\PlanTaskNotFoundException;
use App\Services\PlanTask\Factories\PlanTaskDtoFactory;
use Illuminate\Support\Carbon;

class PlanTaskRepository implements PlanTaskRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(PlanTaskCreateDto $planTaskCreateDto): void
    {
        $planTask          = new PlanTask();
        $planTask->user_id = $planTaskCreateDto->userId;
        $planTask->task_id = $planTaskCreateDto->taskId;
        $planTask->date    = Carbon::createFromTimestamp($planTaskCreateDto->date->getTimestamp());

        if (!$planTask->save()) {
            throw new PlanTaskCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $taskId, int $userId): void
    {
        $planTask = PlanTask::where(['task_id' => $taskId, 'user_id' => $userId])->first();

        if (!$planTask) {
            throw new PlanTaskNotFoundException();
        }

        if (!$planTask->delete()) {
            throw new PlanTaskDeleteFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        $planTasks = PlanTask::with('task', 'task.checklist')
            ->where('user_id', $userId)->get();

        return PlanTaskDtoFactory::createFromModelsList($planTasks);
    }

    /**
     * @inheritDoc
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?PlanTaskDto
    {
        $planTask = PlanTask::where(['task_id' => $taskId, 'user_id' => $userId])->first();

        if (!$planTask) {
            return null;
        }

        return PlanTaskDtoFactory::createFromModel($planTask);
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $taskId, int $userId): bool
    {
        return PlanTask::where(['task_id' => $taskId, 'user_id' => $userId])->exists();
    }

    /**
     * @inheritDoc
     */
    public function countByUserId(int $userId): int
    {
        return PlanTask::where('user_id', $userId)->count();
    }
}

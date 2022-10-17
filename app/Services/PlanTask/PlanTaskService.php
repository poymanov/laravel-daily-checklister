<?php

namespace App\Services\PlanTask;

use App\Services\PlanTask\Contracts\PlanTaskRepositoryContract;
use App\Services\PlanTask\Contracts\PlanTaskServiceContract;
use App\Services\PlanTask\Dtos\PlanTaskCreateDto;
use App\Services\PlanTask\Dtos\PlanTaskDto;
use App\Services\PlanTask\Exceptions\PlanTaskTaskNotFoundException;
use App\Services\PlanTask\Exceptions\PlanTaskUserNotFoundException;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\User\Contracts\UserServiceContract;
use DateTime;

class PlanTaskService implements PlanTaskServiceContract
{
    public function __construct(
        private readonly PlanTaskRepositoryContract $planTaskRepository,
        private readonly UserServiceContract $userService,
        private readonly TaskServiceContract $taskService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function add(int $taskId, int $userId, DateTime $date): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new PlanTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new PlanTaskUserNotFoundException($userId);
        }

        $planTaskCreateDto         = new PlanTaskCreateDto();
        $planTaskCreateDto->taskId = $taskId;
        $planTaskCreateDto->userId = $userId;
        $planTaskCreateDto->date   = $date;

        $this->planTaskRepository->create($planTaskCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function remove(int $taskId, int $userId): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new PlanTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new PlanTaskUserNotFoundException($userId);
        }

        $this->planTaskRepository->delete($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        return $this->planTaskRepository->findAllByUserId($userId);
    }

    /**
     * @inheritDoc
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?PlanTaskDto
    {
        return $this->planTaskRepository->findOneByTaskIdAndUserId($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $taskId, int $userId): bool
    {
        return $this->planTaskRepository->isExists($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function countByUserId(int $userId): int
    {
        return $this->planTaskRepository->countByUserId($userId);
    }
}

<?php

namespace App\Services\DayTask;

use App\Services\DayTask\Contracts\DayTaskRepositoryContract;
use App\Services\DayTask\Contracts\DayTaskServiceContract;
use App\Services\DayTask\Dtos\DayTaskCreateDto;
use App\Services\DayTask\Exceptions\DayTaskTaskNotFoundException;
use App\Services\DayTask\Exceptions\DayTaskUserNotFoundException;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\User\Contracts\UserServiceContract;

class DayTaskService implements DayTaskServiceContract
{
    public function __construct(
        private readonly DayTaskRepositoryContract $dayTaskRepository,
        private readonly UserServiceContract $userService,
        private readonly TaskServiceContract $taskService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function add(int $taskId, int $userId)
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new DayTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new DayTaskUserNotFoundException($userId);
        }

        $dayTaskCreateDto = new DayTaskCreateDto();
        $dayTaskCreateDto->taskId = $taskId;
        $dayTaskCreateDto->userId = $userId;

        $this->dayTaskRepository->create($dayTaskCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function remove(int $taskId, int $userId): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new DayTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new DayTaskUserNotFoundException($userId);
        }

        $this->dayTaskRepository->delete($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $taskId, int $userId): bool
    {
        return $this->dayTaskRepository->isExists($taskId, $userId);
    }
}

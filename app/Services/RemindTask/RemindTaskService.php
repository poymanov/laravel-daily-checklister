<?php

namespace App\Services\RemindTask;

use App\Services\ImportantTask\Exceptions\ImportantTaskTaskNotFoundException;
use App\Services\ImportantTask\Exceptions\ImportantTaskUserNotFoundException;
use App\Services\RemindTask\Contracts\RemindTaskRepositoryContract;
use App\Services\RemindTask\Contracts\RemindTaskServiceContract;
use App\Services\RemindTask\Dtos\RemindTaskCreateDto;
use App\Services\RemindTask\Dtos\RemindTaskDto;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\User\Contracts\UserServiceContract;

class RemindTaskService implements RemindTaskServiceContract
{
    public function __construct(
        private readonly RemindTaskRepositoryContract $remindTaskRepository,
        private readonly TaskServiceContract $taskService,
        private readonly UserServiceContract $userService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $taskId, int $userId, string $date, string $time): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new ImportantTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new ImportantTaskUserNotFoundException($userId);
        }

        $dto         = new RemindTaskCreateDto();
        $dto->taskId = $taskId;
        $dto->userId = $userId;
        $dto->date   = $date;
        $dto->time   = $time;

        $this->remindTaskRepository->create($dto);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $taskId, int $userId): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new ImportantTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new ImportantTaskUserNotFoundException($userId);
        }

        $this->remindTaskRepository->delete($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?RemindTaskDto
    {
        return $this->remindTaskRepository->findOneByTaskIdAndUserId($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->remindTaskRepository->findAll();
    }
}

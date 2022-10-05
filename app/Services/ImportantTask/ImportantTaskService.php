<?php

namespace App\Services\ImportantTask;

use App\Services\ImportantTask\Contracts\ImportantTaskRepositoryContract;
use App\Services\ImportantTask\Contracts\ImportantTaskServiceContract;
use App\Services\ImportantTask\Dtos\ImportantTaskCreateDto;
use App\Services\ImportantTask\Exceptions\ImportantTaskTaskNotFoundException;
use App\Services\ImportantTask\Exceptions\ImportantTaskUserNotFoundException;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\User\Contracts\UserServiceContract;

class ImportantTaskService implements ImportantTaskServiceContract
{
    public function __construct(
        private readonly ImportantTaskRepositoryContract $importantTaskRepository,
        private readonly UserServiceContract $userService,
        private readonly TaskServiceContract $taskService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function add(int $taskId, int $userId): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new ImportantTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new ImportantTaskUserNotFoundException($userId);
        }

        $importantTaskCreateDto = new ImportantTaskCreateDto();
        $importantTaskCreateDto->taskId = $taskId;
        $importantTaskCreateDto->userId = $userId;

        $this->importantTaskRepository->create($importantTaskCreateDto);
    }

    /**
     * @inheritDoc
     */
    public function remove(int $taskId, int $userId): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new ImportantTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new ImportantTaskUserNotFoundException($userId);
        }

        $this->importantTaskRepository->delete($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function findAllByUserId(int $userId): array
    {
        return $this->importantTaskRepository->findAllByUserId($userId);
    }

    /**
     * @inheritDoc
     */
    public function isExists(int $taskId, int $userId): bool
    {
        return $this->importantTaskRepository->isExists($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function countByUserId(int $userId): int
    {
        return $this->importantTaskRepository->countByUserId($userId);
    }
}

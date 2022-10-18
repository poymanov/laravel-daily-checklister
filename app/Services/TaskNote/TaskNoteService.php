<?php

namespace App\Services\TaskNote;

use App\Services\ImportantTask\Exceptions\ImportantTaskTaskNotFoundException;
use App\Services\ImportantTask\Exceptions\ImportantTaskUserNotFoundException;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\TaskNote\Contracts\TaskNoteRepositoryContract;
use App\Services\TaskNote\Contracts\TaskNoteServiceContract;
use App\Services\TaskNote\Dtos\TaskNoteCreateUpdateDto;
use App\Services\TaskNote\Dtos\TaskNoteDto;
use App\Services\User\Contracts\UserServiceContract;

class TaskNoteService implements TaskNoteServiceContract
{
    public function __construct(
        private readonly TaskNoteRepositoryContract $taskNoteRepository,
        private readonly TaskServiceContract $taskService,
        private readonly UserServiceContract $userService
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $taskId, int $userId, string $text): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new ImportantTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new ImportantTaskUserNotFoundException($userId);
        }

        $dto         = new TaskNoteCreateUpdateDto();
        $dto->taskId = $taskId;
        $dto->userId = $userId;
        $dto->text   = $text;

        $this->taskNoteRepository->create($dto);
    }

    /**
     * @inheritDoc
     */
    public function update(int $taskId, int $userId, string $text): void
    {
        if (!$this->taskService->isExists($taskId)) {
            throw new ImportantTaskTaskNotFoundException($taskId);
        }

        if (!$this->userService->isExists($userId)) {
            throw new ImportantTaskUserNotFoundException($userId);
        }

        $dto         = new TaskNoteCreateUpdateDto();
        $dto->taskId = $taskId;
        $dto->userId = $userId;
        $dto->text   = $text;

        $this->taskNoteRepository->update($dto);
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

        $this->taskNoteRepository->delete($taskId, $userId);
    }

    /**
     * @inheritDoc
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?TaskNoteDto
    {
        return $this->taskNoteRepository->findOneByTaskIdAndUserId($taskId, $userId);
    }
}

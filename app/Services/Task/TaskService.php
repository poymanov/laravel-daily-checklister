<?php

namespace App\Services\Task;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;

class TaskService implements TaskServiceContract
{
    public function __construct(
        private ChecklistServiceContract $checklistService,
        private TaskRepositoryContract $taskRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $checklistId, string $name, string $description): void
    {
        $this->checklistService->findOneById($checklistId);

        $dto              = new TaskCreateDto();
        $dto->checklistId = $checklistId;
        $dto->name        = $name;
        $dto->description = $description;

        $this->taskRepository->create($dto);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, string $name, string $description): void
    {
        $dto              = new TaskUpdateDto();
        $dto->name        = $name;
        $dto->description = $description;

        $this->taskRepository->update($id, $dto);
    }
}

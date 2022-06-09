<?php

namespace App\Services\Task;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;

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
    public function create(TaskCreateDto $taskCreateDto): void
    {
        $this->checklistService->findOneById($taskCreateDto->checklistId);
        $this->taskRepository->create($taskCreateDto);
    }
}

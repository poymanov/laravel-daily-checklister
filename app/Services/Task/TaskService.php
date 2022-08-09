<?php

namespace App\Services\Task;

use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Task\Contracts\TaskRepositoryContract;
use App\Services\Task\Contracts\TaskServiceContract;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use Mews\Purifier\Facades\Purifier;

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
        $order = $this->checklistService->getNextTaskOrder($checklistId);

        $dto              = new TaskCreateDto();
        $dto->checklistId = $checklistId;
        $dto->name        = $name;
        $dto->description = Purifier::clean($description);
        $dto->order       = $order;

        $this->taskRepository->create($dto);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, string $name, string $description): void
    {
        $dto              = new TaskUpdateDto();
        $dto->name        = $name;
        $dto->description = Purifier::clean($description);

        $this->taskRepository->update($id, $dto);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->taskRepository->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function findAllByChecklistId(int $checklistId): array
    {
        return $this->taskRepository->findAllByChecklistId($checklistId);
    }

    /**
     * @inheritDoc
     */
    public function changeOrder(int $id, ChangeOrderDirectionEnum $direction): void
    {
        $this->taskRepository->changeOrder($id, $direction);
    }

    /**
     * @inheritDoc
     */
    public function complete(int $id, int $completedBy): void
    {
        $this->taskRepository->complete($id, $completedBy, now()->toString());
    }

    /**
     * @inheritDoc
     */
    public function incomplete(int $id): void
    {
        $this->taskRepository->incomplete($id);
    }
}

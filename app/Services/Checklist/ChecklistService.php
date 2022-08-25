<?php

namespace App\Services\Checklist;

use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
use App\Services\Checklist\Dtos\ChecklistDto;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;

class ChecklistService implements ChecklistServiceContract
{
    public function __construct(
        private ChecklistGroupServiceContract $checklistGroupService,
        private ChecklistRepositoryContract $checklistRepository
    ) {
    }

    /**
     * @inheritDoc
     */
    public function create(int $checklistGroupId, string $name): void
    {
        $checklistGroup = $this->checklistGroupService->findOneById($checklistGroupId);
        $this->checklistRepository->create($checklistGroup->id, $name);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, string $name, bool $isTop): void
    {
        $this->checklistRepository->update($id, $name, $isTop);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->checklistRepository->delete($id);
    }

    /**
     * @inheritDoc
     */
    public function findOneById(int $id): ChecklistDto
    {
        return $this->checklistRepository->findOneById($id);
    }

    /**
     * @inheritDoc
     */
    public function findAllTop(): array
    {
        return $this->checklistRepository->findAllTop();
    }

    /**
     * @inheritDoc
     */
    public function getNextTaskOrder(int $id): int
    {
        return $this->checklistRepository->getNextTaskOrder($id);
    }

    /**
     * @inheritDoc
     */
    public function getTasksLastOrder(int $id): int
    {
        return $this->checklistRepository->getTasksLastOrder($id);
    }

    /**
     * @inheritDoc
     */
    public function countTasks(int $id): int
    {
        return $this->checklistRepository->countTasks($id);
    }

    /**
     * @inheritDoc
     */
    public function countCompletedTasks(int $id): int
    {
        return $this->checklistRepository->countCompletedTasks($id);
    }
}

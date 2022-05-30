<?php

namespace App\Services\Checklist;

use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Contracts\ChecklistServiceContract;
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
    public function update(int $id, string $name): void
    {
        $this->checklistRepository->update($id, $name);
    }
}

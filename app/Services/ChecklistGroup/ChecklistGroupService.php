<?php

namespace App\Services\ChecklistGroup;

use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupServiceContract;

class ChecklistGroupService implements ChecklistGroupServiceContract
{
    public function __construct(private ChecklistGroupRepositoryContract $checklistGroupRepository)
    {
    }

    /**
     * @inheritDoc
     */
    public function create(string $name): void
    {
        $this->checklistGroupRepository->create($name);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, string $name): void
    {
        $this->checklistGroupRepository->update($id, $name);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $this->checklistGroupRepository->delete($id);
    }
}

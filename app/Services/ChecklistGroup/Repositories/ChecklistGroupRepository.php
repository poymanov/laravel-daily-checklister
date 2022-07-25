<?php

namespace App\Services\ChecklistGroup\Repositories;

use App\Models\ChecklistGroup;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Dtos\ChecklistGroupDto;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupCreateFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupDeleteFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupUpdateFailedException;
use App\Services\ChecklistGroup\Factories\ChecklistGroupDtoFactory;

class ChecklistGroupRepository implements ChecklistGroupRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(string $name): void
    {
        $checklistGroup       = new ChecklistGroup();
        $checklistGroup->name = $name;

        if (!$checklistGroup->save()) {
            throw new ChecklistGroupCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, string $name): void
    {
        $checklistGroup       = $this->findModelById($id);
        $checklistGroup->name = $name;

        if (!$checklistGroup->save()) {
            throw new ChecklistGroupUpdateFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $checklistGroup = $this->findModelById($id);

        if (!$checklistGroup->delete()) {
            throw new ChecklistGroupDeleteFailedException($checklistGroup->id);
        }
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return ChecklistGroupDtoFactory::createFromModelsList(ChecklistGroup::select('id', 'name')->with('checklists')->get());
    }

    /**
     * @inheritDoc
     */
    public function findOneById(int $id): ChecklistGroupDto
    {
        return ChecklistGroupDtoFactory::createFromModel($this->findModelById($id));
    }

    /**
     * Получение модели по ID
     *
     * @param int $id
     *
     * @return ChecklistGroup
     * @throws ChecklistGroupNotFoundException
     */
    private function findModelById(int $id): ChecklistGroup
    {
        $checklistGroup = ChecklistGroup::find($id);

        if (!$checklistGroup) {
            throw new ChecklistGroupNotFoundException($id);
        }

        return $checklistGroup;
    }
}

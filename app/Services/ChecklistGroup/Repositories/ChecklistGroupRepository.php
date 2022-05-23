<?php

namespace App\Services\ChecklistGroup\Repositories;

use App\Models\ChecklistGroup;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupCreateFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupUpdateFailedException;

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
        $checklistGroup = ChecklistGroup::find($id);

        if (!$checklistGroup) {
            throw new ChecklistGroupNotFoundException($id);
        }

        $checklistGroup->name = $name;

        if (!$checklistGroup->save()) {
            throw new ChecklistGroupUpdateFailedException($id);
        }
    }
}

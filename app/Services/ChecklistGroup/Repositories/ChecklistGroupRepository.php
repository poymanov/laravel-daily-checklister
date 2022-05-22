<?php

namespace App\Services\ChecklistGroup\Repositories;

use App\Models\ChecklistGroup;
use App\Services\ChecklistGroup\Contracts\ChecklistGroupRepositoryContract;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupCreateFailedException;

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
}

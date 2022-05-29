<?php

namespace App\Services\Checklist\Repositories;

use App\Models\Checklist;
use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;

class ChecklistRepository implements ChecklistRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(int $checklistGroupId, string $name): void
    {
        $checklist                     = new Checklist();
        $checklist->name               = $name;
        $checklist->checklist_group_id = $checklistGroupId;

        if (!$checklist->save()) {
            throw new ChecklistCreateFailedException();
        }
    }
}

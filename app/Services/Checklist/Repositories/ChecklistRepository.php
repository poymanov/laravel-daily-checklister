<?php

namespace App\Services\Checklist\Repositories;

use App\Models\Checklist;
use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Checklist\Exceptions\ChecklistUpdateFailedException;

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

    /**
     * @inheritDoc
     */
    public function update(int $id, string $name): void
    {
        $checklist = Checklist::find($id);

        if (!$checklist) {
            throw new ChecklistNotFoundException($id);
        }

        $checklist->name = $name;

        if (!$checklist->save()) {
            throw new ChecklistUpdateFailedException($id);
        }
    }
}

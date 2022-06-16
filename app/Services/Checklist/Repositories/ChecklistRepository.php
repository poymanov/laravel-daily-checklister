<?php

namespace App\Services\Checklist\Repositories;

use App\Models\Checklist;
use App\Services\Checklist\Contracts\ChecklistRepositoryContract;
use App\Services\Checklist\Dtos\ChecklistDto;
use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;
use App\Services\Checklist\Exceptions\ChecklistDeleteFailedException;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Checklist\Exceptions\ChecklistUpdateFailedException;
use App\Services\Checklist\Factories\ChecklistDtoFactory;

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
        $checklist       = $this->findModelById($id);
        $checklist->name = $name;

        if (!$checklist->save()) {
            throw new ChecklistUpdateFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): void
    {
        $checklist = $this->findModelById($id);

        if (!$checklist->delete()) {
            throw new ChecklistDeleteFailedException($id);
        }
    }

    /**
     * @inheritDoc
     */
    public function findOneById(int $id): ChecklistDto
    {
        return ChecklistDtoFactory::createFromModel($this->findModelById($id));
    }

    /**
     * @inheritDoc
     */
    public function getNextTaskOrder(int $id): int
    {
        $checklist = $this->findModelById($id);

        $order = (int) $checklist->tasks()->max('order');
        $order++;

        return $order;
    }

    /**
     * Получение модели по ID
     *
     * @param int $id
     *
     * @return Checklist
     * @throws ChecklistNotFoundException
     */
    private function findModelById(int $id): Checklist
    {
        $checklist = Checklist::find($id);

        if (!$checklist) {
            throw new ChecklistNotFoundException($id);
        }

        $checklist->with('tasks');

        return $checklist;
    }
}

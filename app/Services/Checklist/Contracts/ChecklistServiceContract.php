<?php

namespace App\Services\Checklist\Contracts;

use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Checklist\Exceptions\ChecklistUpdateFailedException;
use App\Services\ChecklistGroup\Exceptions\ChecklistGroupNotFoundException;

interface ChecklistServiceContract
{
    /**
     * @param int    $checklistGroupId
     * @param string $name
     *
     * @return void
     * @throws ChecklistCreateFailedException
     * @throws ChecklistGroupNotFoundException
     */
    public function create(int $checklistGroupId, string $name): void;

    /**
     * @param int    $id
     * @param string $name
     *
     * @return void
     * @throws ChecklistNotFoundException
     * @throws ChecklistUpdateFailedException
     */
    public function update(int $id, string $name);
}

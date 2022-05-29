<?php

namespace App\Services\Checklist\Contracts;

use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;
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
}

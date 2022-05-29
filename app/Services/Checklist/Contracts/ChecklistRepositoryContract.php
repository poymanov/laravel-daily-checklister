<?php

namespace App\Services\Checklist\Contracts;

use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;

interface ChecklistRepositoryContract
{
    /**
     * @param int    $checklistGroupId
     * @param string $name
     *
     * @return void
     * @throws ChecklistCreateFailedException
     */
    public function create(int $checklistGroupId, string $name): void;
}

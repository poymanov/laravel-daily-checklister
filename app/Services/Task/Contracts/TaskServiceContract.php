<?php

namespace App\Services\Task\Contracts;

use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;

interface TaskServiceContract
{
    /**
     * @param int    $checklistId
     * @param string $name
     * @param string $description
     *
     * @return void
     * @throws TaskCreateFailedException
     * @throws ChecklistNotFoundException
     */
    public function create(int $checklistId, string $name, string $description): void;

    /**
     * @param int    $id
     * @param string $name
     * @param string $description
     *
     * @return void
     * @throws TaskNotFoundException
     * @throws TaskUpdateFailedException
     */
    public function update(int $id, string $name, string $description): void;
}

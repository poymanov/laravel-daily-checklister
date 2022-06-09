<?php

namespace App\Services\Task\Contracts;

use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;

interface TaskServiceContract
{
    /**
     * @param TaskCreateDto $taskCreateDto
     *
     * @return void
     * @throws TaskCreateFailedException
     * @throws ChecklistNotFoundException
     */
    public function create(TaskCreateDto $taskCreateDto): void;
}

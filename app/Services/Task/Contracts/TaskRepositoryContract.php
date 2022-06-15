<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;

interface TaskRepositoryContract
{
    /**
     * @param TaskCreateDto $taskCreateDto
     *
     * @return void
     * @throws TaskCreateFailedException
     */
    public function create(TaskCreateDto $taskCreateDto): void;

    /**
     * @param int           $id
     * @param TaskUpdateDto $taskUpdateDto
     *
     * @return void
     * @throws TaskNotFoundException
     * @throws TaskUpdateFailedException
     */
    public function update(int $id, TaskUpdateDto $taskUpdateDto): void;

    /**
     * @param int $id
     *
     * @return void
     * @throws TaskDeleteFailedException
     * @throws TaskNotFoundException
     */
    public function delete(int $id): void;
}

<?php

namespace App\Services\Task\Contracts;

use App\Services\Task\Dtos\TaskCreateDto;
use App\Services\Task\Dtos\TaskDto;
use App\Services\Task\Dtos\TaskUpdateDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use Throwable;

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

    /**
     * Получение задач по ID чеклиста
     *
     * @param int $checklistId
     *
     * @return TaskDto[]
     */
    public function findAllByChecklistId(int $checklistId): array;

    /**
     * Изменение порядка задачи
     *
     * @param int                      $id
     * @param ChangeOrderDirectionEnum $direction
     *
     * @return void
     * @throws TaskNotFoundException
     * @throws Throwable
     */
    public function changeOrder(int $id, ChangeOrderDirectionEnum $direction): void;
}

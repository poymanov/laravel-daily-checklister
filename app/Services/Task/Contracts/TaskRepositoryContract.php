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
     * @param int      $checklistId
     * @param int|null $limit
     *
     * @return TaskDto[]
     */
    public function findAllByChecklistId(int $checklistId, ?int $limit = null): array;

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

    /**
     * Завершение задачи
     *
     * @param int    $id
     * @param int    $completedBy
     * @param string $completedAt
     *
     * @return void
     * @throws TaskNotFoundException
     */
    public function complete(int $id, int $completedBy, string $completedAt): void;

    /**
     * Отмена завершения задачи
     *
     * @param int $id
     *
     * @return void
     * @throws TaskNotFoundException
     */
    public function incomplete(int $id): void;

    /**
     * Проверка существования задачи по ID
     *
     * @param int $id
     *
     * @return bool
     */
    public function isExists(int $id): bool;
}

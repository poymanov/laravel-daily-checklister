<?php

namespace App\Services\Task\Contracts;

use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Task\Dtos\TaskDto;
use App\Services\Task\Enums\ChangeOrderDirectionEnum;
use App\Services\Task\Exceptions\TaskCreateFailedException;
use App\Services\Task\Exceptions\TaskDeleteFailedException;
use App\Services\Task\Exceptions\TaskNotFoundException;
use App\Services\Task\Exceptions\TaskUpdateFailedException;
use Throwable;

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

    /**
     * @param int $id
     *
     * @return void
     * @throws TaskDeleteFailedException
     * @throws TaskNotFoundException
     */
    public function delete(int $id): void;

    /**
     * Получение задач по ID чеклиста с ограничением количества
     *
     * @param int $checklistId
     * @param int $limit
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
     * @param int $id
     * @param int $completedBy
     *
     * @return void
     * @throws TaskNotFoundException
     */
    public function complete(int $id, int $completedBy): void;

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

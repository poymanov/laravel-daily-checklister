<?php

namespace App\Services\Checklist\Contracts;

use App\Services\Checklist\Dtos\ChecklistDto;
use App\Services\Checklist\Exceptions\ChecklistCreateFailedException;
use App\Services\Checklist\Exceptions\ChecklistDeleteFailedException;
use App\Services\Checklist\Exceptions\ChecklistNotFoundException;
use App\Services\Checklist\Exceptions\ChecklistUpdateFailedException;

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

    /**
     * @param int    $id
     * @param string $name
     * @param bool   $isTop
     *
     * @return void
     * @throws ChecklistNotFoundException
     * @throws ChecklistUpdateFailedException
     */
    public function update(int $id, string $name, bool $isTop): void;

    /**
     * @param int $id
     *
     * @return void
     * @throws ChecklistDeleteFailedException
     * @throws ChecklistNotFoundException
     */
    public function delete(int $id): void;

    /**
     * @param int $id
     *
     * @return ChecklistDto
     * @throws ChecklistNotFoundException
     */
    public function findOneById(int $id): ChecklistDto;

    /**
     * Получение списка чеклистов, с признаком Top
     *
     * @return ChecklistDto[]
     */
    public function findAllTop(): array;

    /**
     * Получение порядкового номера для следующей задачи в чеклисте
     *
     * @param int $id
     *
     * @return int
     * @throws ChecklistNotFoundException
     */
    public function getNextTaskOrder(int $id): int;

    /**
     * Получение последнего значения сортировки задач
     *
     * @param int $id
     *
     * @return int
     * @throws ChecklistNotFoundException
     */
    public function getTasksLastOrder(int $id): int;

    /**
     * Общее количество задач
     *
     * @param int $id
     *
     * @return int
     * @throws ChecklistNotFoundException
     */
    public function countTasks(int $id): int;

    /**
     * Общее количество завершенных задач
     *
     * @param int $id
     *
     * @return int
     * @throws ChecklistNotFoundException
     */
    public function countCompletedTasks(int $id): int;
}

<?php

namespace App\Services\PlanTask\Contracts;

use App\Services\PlanTask\Dtos\PlanTaskCreateDto;
use App\Services\PlanTask\Dtos\PlanTaskDto;
use App\Services\PlanTask\Exceptions\PlanTaskCreateFailedException;
use App\Services\PlanTask\Exceptions\PlanTaskDeleteFailedException;
use App\Services\PlanTask\Exceptions\PlanTaskNotFoundException;

interface PlanTaskRepositoryContract
{
    /**
     * Добавление задачи в запланированные задачи
     *
     * @param PlanTaskCreateDto $planTaskCreateDto
     *
     * @return void
     * @throws PlanTaskCreateFailedException
     */
    public function create(PlanTaskCreateDto $planTaskCreateDto): void;

    /**
     * Удаление задачи из запланированных задач
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws PlanTaskDeleteFailedException
     * @throws PlanTaskNotFoundException
     */
    public function delete(int $taskId, int $userId): void;

    /**
     * Получение запланированной задачи по ID задачи
     *
     * @param int $taskId
     *
     * @return PlanTaskDto|null
     */
    public function findOneByTaskId(int $taskId): ?PlanTaskDto;
}

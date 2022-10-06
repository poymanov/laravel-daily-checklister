<?php

namespace App\Services\PlanTask\Contracts;

use App\Services\PlanTask\Dtos\PlanTaskDto;
use App\Services\PlanTask\Exceptions\PlanTaskCreateFailedException;
use App\Services\PlanTask\Exceptions\PlanTaskDeleteFailedException;
use App\Services\PlanTask\Exceptions\PlanTaskNotFoundException;
use App\Services\PlanTask\Exceptions\PlanTaskTaskNotFoundException;
use App\Services\PlanTask\Exceptions\PlanTaskUserNotFoundException;
use DateTime;

interface PlanTaskServiceContract
{
    /**
     * Добавление задачи в запланированные задачи
     *
     * @param int      $taskId
     * @param int      $userId
     * @param DateTime $date
     *
     * @return void
     * @throws PlanTaskCreateFailedException
     * @throws PlanTaskTaskNotFoundException
     * @throws PlanTaskUserNotFoundException
     */
    public function add(int $taskId, int $userId, DateTime $date): void;

    /**
     * Удаление задачи из запланированных задач
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws PlanTaskDeleteFailedException
     * @throws PlanTaskNotFoundException
     * @throws PlanTaskTaskNotFoundException
     * @throws PlanTaskUserNotFoundException
     */
    public function remove(int $taskId, int $userId): void;

    /**
     * Получение запланированной задачи по ID задачи
     *
     * @param int $taskId
     *
     * @return PlanTaskDto|null
     */
    public function findOneByTaskId(int $taskId): ?PlanTaskDto;
}

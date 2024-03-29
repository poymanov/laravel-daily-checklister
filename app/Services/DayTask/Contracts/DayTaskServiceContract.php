<?php

namespace App\Services\DayTask\Contracts;

use App\Services\DayTask\Dtos\DayTaskDto;
use App\Services\DayTask\Exceptions\DayTaskCreateFailedException;
use App\Services\DayTask\Exceptions\DayTaskNotFoundException;
use App\Services\DayTask\Exceptions\DayTaskTaskNotFoundException;
use App\Services\DayTask\Exceptions\DayTaskUserNotFoundException;

interface DayTaskServiceContract
{
    /**
     * Добавление задачи в задачи дня
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws DayTaskTaskNotFoundException
     * @throws DayTaskUserNotFoundException
     * @throws DayTaskCreateFailedException
     */
    public function add(int $taskId, int $userId);

    /**
     * Получение всех задач дня
     *
     * @param int $userId
     *
     * @return DayTaskDto[]
     */
    public function findAllByUserId(int $userId): array;

    /**
     * Удаление задач из задач дня
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws DayTaskCreateFailedException
     * @throws DayTaskNotFoundException
     */
    public function remove(int $taskId, int $userId): void;

    /**
     * Проверка существования записи о задаче для пользователя
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return bool
     */
    public function isExists(int $taskId, int $userId): bool;

    /**
     * Получение количества задач дня для пользователя
     *
     * @param int $userId
     *
     * @return int
     */
    public function countByUserId(int $userId): int;
}

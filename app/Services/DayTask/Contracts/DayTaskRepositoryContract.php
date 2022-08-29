<?php

namespace App\Services\DayTask\Contracts;

use App\Services\DayTask\Dtos\DayTaskCreateDto;
use App\Services\DayTask\Exceptions\DayTaskCreateFailedException;
use App\Services\DayTask\Exceptions\DayTaskNotFoundException;

interface DayTaskRepositoryContract
{
    /**
     * Добавление задачи в задачи дня
     *
     * @param DayTaskCreateDto $dayTaskCreateDto
     *
     * @return void
     * @throws DayTaskCreateFailedException
     */
    public function create(DayTaskCreateDto $dayTaskCreateDto): void;

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
    public function delete(int $taskId, int $userId): void;

    /**
     * Проверка существования записи о задаче для пользователя
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return bool
     */
    public function isExists(int $taskId, int $userId): bool;
}

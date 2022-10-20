<?php

namespace App\Services\RemindTask\Contracts;

use App\Services\RemindTask\Dtos\RemindTaskCreateDto;
use App\Services\RemindTask\Dtos\RemindTaskDto;
use App\Services\RemindTask\Exceptions\RemindTaskCreateFailedException;
use App\Services\RemindTask\Exceptions\RemindTaskDeleteFailedException;
use App\Services\RemindTask\Exceptions\RemindTaskNotFoundException;

interface RemindTaskRepositoryContract
{
    /**
     * Создание напоминания о задаче
     *
     * @param RemindTaskCreateDto $dto
     *
     * @return void
     * @throws RemindTaskCreateFailedException
     */
    public function create(RemindTaskCreateDto $dto): void;

    /**
     * Удаление напоминания о задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws RemindTaskDeleteFailedException
     * @throws RemindTaskNotFoundException
     */
    public function delete(int $taskId, int $userId): void;

    /**
     * Получение напоминания о задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return RemindTaskDto|null
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?RemindTaskDto;

    /**
     * Получение всех напоминаний
     *
     * @return RemindTaskDto[]
     */
    public function findAll(): array;
}

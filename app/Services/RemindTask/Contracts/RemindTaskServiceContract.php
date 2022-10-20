<?php

namespace App\Services\RemindTask\Contracts;

use App\Services\ImportantTask\Exceptions\ImportantTaskTaskNotFoundException;
use App\Services\ImportantTask\Exceptions\ImportantTaskUserNotFoundException;
use App\Services\RemindTask\Dtos\RemindTaskDto;
use App\Services\RemindTask\Exceptions\RemindTaskCreateFailedException;
use App\Services\RemindTask\Exceptions\RemindTaskDeleteFailedException;
use App\Services\RemindTask\Exceptions\RemindTaskNotFoundException;

interface RemindTaskServiceContract
{
    /**
     * Создание напоминания о задаче
     *
     * @param int    $taskId
     * @param int    $userId
     * @param string $date
     * @param string $time
     *
     * @return void
     * @throws RemindTaskCreateFailedException
     * @throws ImportantTaskTaskNotFoundException
     * @throws ImportantTaskUserNotFoundException
     */
    public function create(int $taskId, int $userId, string $date, string $time): void;

    /**
     * Удаление напоминания о задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws RemindTaskDeleteFailedException
     * @throws RemindTaskNotFoundException
     * @throws ImportantTaskTaskNotFoundException
     * @throws ImportantTaskUserNotFoundException
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

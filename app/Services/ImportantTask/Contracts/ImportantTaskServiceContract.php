<?php

namespace App\Services\ImportantTask\Contracts;

use App\Services\ImportantTask\Exceptions\ImportantTaskCreateFailedException;
use App\Services\ImportantTask\Exceptions\ImportantTaskDeleteFailedException;
use App\Services\ImportantTask\Exceptions\ImportantTaskNotFoundException;
use App\Services\ImportantTask\Exceptions\ImportantTaskTaskNotFoundException;
use App\Services\ImportantTask\Exceptions\ImportantTaskUserNotFoundException;

interface ImportantTaskServiceContract
{
    /**
     * Добавление задачи в важные задачи
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws ImportantTaskCreateFailedException
     * @throws ImportantTaskTaskNotFoundException
     * @throws ImportantTaskUserNotFoundException
     */
    public function add(int $taskId, int $userId): void;

    /**
     * Удаление задачи из важных задач
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws ImportantTaskDeleteFailedException
     * @throws ImportantTaskNotFoundException
     * @throws ImportantTaskTaskNotFoundException
     * @throws ImportantTaskUserNotFoundException
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
}

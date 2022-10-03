<?php

namespace App\Services\ImportantTask\Contracts;

use App\Services\ImportantTask\Dtos\ImportantTaskCreateDto;
use App\Services\ImportantTask\Exceptions\ImportantTaskCreateFailedException;
use App\Services\ImportantTask\Exceptions\ImportantTaskDeleteFailedException;
use App\Services\ImportantTask\Exceptions\ImportantTaskNotFoundException;

interface ImportantTaskRepositoryContract
{
    /**
     * Добавление задачи в важные задачи
     *
     * @param ImportantTaskCreateDto $importantTaskCreateDto
     *
     * @return void
     * @throws ImportantTaskCreateFailedException
     */
    public function create(ImportantTaskCreateDto $importantTaskCreateDto): void;

    /**
     * Удаление задачи из важных задач
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws ImportantTaskDeleteFailedException
     * @throws ImportantTaskNotFoundException
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

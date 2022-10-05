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
     * Получение всех важных задач
     *
     * @param int $userId
     *
     * @return array
     */
    public function findAllByUserId(int $userId): array;

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
     * Получение количества важных задач для пользователя
     *
     * @param int $userId
     *
     * @return int
     */
    public function countByUserId(int $userId): int;
}

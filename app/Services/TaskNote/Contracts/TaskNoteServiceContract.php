<?php

namespace App\Services\TaskNote\Contracts;

use App\Services\TaskNote\Dtos\TaskNoteDto;
use App\Services\TaskNote\Exceptions\TaskNoteCreateFailedException;
use App\Services\TaskNote\Exceptions\TaskNoteDeleteFailedException;
use App\Services\TaskNote\Exceptions\TaskNoteNotFoundException;
use App\Services\TaskNote\Exceptions\TaskNoteUpdateFailedException;

interface TaskNoteServiceContract
{
    /**
     * Создание заметки для задачи
     *
     * @param int    $taskId
     * @param int    $userId
     * @param string $text
     *
     * @return void
     * @throws TaskNoteCreateFailedException
     */
    public function create(int $taskId, int $userId, string $text): void;

    /**
     * Обновление заметки о задаче
     *
     * @param int    $taskId
     * @param int    $userId
     * @param string $text
     *
     * @return void
     * @throws TaskNoteNotFoundException
     * @throws TaskNoteUpdateFailedException
     */
    public function update(int $taskId, int $userId, string $text): void;

    /**
     * Удаление заметки по задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return void
     * @throws TaskNoteDeleteFailedException
     * @throws TaskNoteNotFoundException
     */
    public function delete(int $taskId, int $userId): void;

    /**
     * Получение заметки по задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return TaskNoteDto|null
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?TaskNoteDto;
}

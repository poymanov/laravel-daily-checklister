<?php

namespace App\Services\TaskNote\Contracts;

use App\Services\TaskNote\Dtos\TaskNoteCreateUpdateDto;
use App\Services\TaskNote\Dtos\TaskNoteDto;
use App\Services\TaskNote\Exceptions\TaskNoteCreateFailedException;
use App\Services\TaskNote\Exceptions\TaskNoteDeleteFailedException;
use App\Services\TaskNote\Exceptions\TaskNoteNotFoundException;
use App\Services\TaskNote\Exceptions\TaskNoteUpdateFailedException;

interface TaskNoteRepositoryContract
{
    /**
     * Создание заметки для задачи
     *
     * @param TaskNoteCreateUpdateDto $dto
     *
     * @return void
     * @throws TaskNoteCreateFailedException
     */
    public function create(TaskNoteCreateUpdateDto $dto): void;

    /**
     * Обновление заметки о задаче
     *
     * @param TaskNoteCreateUpdateDto $dto
     *
     * @return void
     * @throws TaskNoteNotFoundException
     * @throws TaskNoteUpdateFailedException
     */
    public function update(TaskNoteCreateUpdateDto $dto): void;

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

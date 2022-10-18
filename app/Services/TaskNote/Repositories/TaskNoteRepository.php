<?php

namespace App\Services\TaskNote\Repositories;

use App\Models\TaskNote;
use App\Services\TaskNote\Contracts\TaskNoteRepositoryContract;
use App\Services\TaskNote\Dtos\TaskNoteCreateUpdateDto;
use App\Services\TaskNote\Dtos\TaskNoteDto;
use App\Services\TaskNote\Exceptions\TaskNoteCreateFailedException;
use App\Services\TaskNote\Exceptions\TaskNoteDeleteFailedException;
use App\Services\TaskNote\Exceptions\TaskNoteNotFoundException;
use App\Services\TaskNote\Exceptions\TaskNoteUpdateFailedException;
use App\Services\TaskNote\Factories\TaskNoteDtoFactory;
use Throwable;

class TaskNoteRepository implements TaskNoteRepositoryContract
{
    /**
     * @inheritDoc
     */
    public function create(TaskNoteCreateUpdateDto $dto): void
    {
        $taskNote          = new TaskNote();
        $taskNote->user_id = $dto->userId;
        $taskNote->task_id = $dto->taskId;
        $taskNote->text    = $dto->text;

        if (!$taskNote->save()) {
            throw new TaskNoteCreateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function update(TaskNoteCreateUpdateDto $dto): void
    {
        $taskNote       = $this->findOneByTaskIdAndUserIdAsModel($dto->taskId, $dto->userId);
        $taskNote->text = $dto->text;

        if (!$taskNote->save()) {
            throw new TaskNoteUpdateFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $taskId, int $userId): void
    {
        $taskNote = $this->findOneByTaskIdAndUserIdAsModel($taskId, $userId);

        if (!$taskNote->delete()) {
            throw new TaskNoteDeleteFailedException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findOneByTaskIdAndUserId(int $taskId, int $userId): ?TaskNoteDto
    {
        try {
            return TaskNoteDtoFactory::createFromModel($this->findOneByTaskIdAndUserIdAsModel($taskId, $userId));
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * Получение AR-объекта заметки о задаче
     *
     * @param int $taskId
     * @param int $userId
     *
     * @return TaskNote
     * @throws TaskNoteNotFoundException
     */
    private function findOneByTaskIdAndUserIdAsModel(int $taskId, int $userId): TaskNote
    {
        $taskNote = TaskNote::where(['user_id' => $userId, 'task_id' => $taskId])->first();

        if (!$taskNote) {
            throw new TaskNoteNotFoundException();
        }

        return $taskNote;
    }
}

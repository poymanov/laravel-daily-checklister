<?php

namespace App\Services\TaskNote\Factories;

use App\Models\TaskNote;
use App\Services\TaskNote\Dtos\TaskNoteDto;
use Illuminate\Database\Eloquent\Collection;

class TaskNoteDtoFactory
{
    /**
     * @param TaskNote $taskNote
     *
     * @return TaskNoteDto
     */
    public static function createFromModel(TaskNote $taskNote): TaskNoteDto
    {
        $dto            = new TaskNoteDto();
        $dto->taskId = $taskNote->task_id;
        $dto->userId    = $taskNote->user_id;
        $dto->text      = $taskNote->text;

        return $dto;
    }

    /**
     * @param Collection $models
     *
     * @return TaskNoteDto[]
     */
    public static function createFromModelsList(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = self::createFromModel($model);
        }

        return $dtos;
    }
}

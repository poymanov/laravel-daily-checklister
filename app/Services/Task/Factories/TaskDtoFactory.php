<?php

namespace App\Services\Task\Factories;

use App\Models\Task;
use App\Services\Task\Dtos\TaskDto;
use Illuminate\Database\Eloquent\Collection;
use Mews\Purifier\Facades\Purifier;

class TaskDtoFactory
{
    /**
     * @param Collection $models
     *
     * @return array
     */
    public static function createFromModelsList(Collection $models): array
    {
        $dtos = [];

        foreach ($models as $model) {
            $dtos[] = self::createFromModel($model);
        }

        return $dtos;
    }

    /**
     * @param Task $task
     *
     * @return TaskDto
     */
    public static function createFromModel(Task $task): TaskDto
    {
        $dto              = new TaskDto();
        $dto->id          = $task->id;
        $dto->name        = $task->name;
        $dto->order       = $task->order;
        $dto->description = Purifier::clean($task->description);
        $dto->completed   = $task->completed;

        return $dto;
    }
}

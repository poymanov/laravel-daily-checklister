<?php

namespace App\Services\RemindTask\Factories;

use App\Models\RemindTask;
use App\Services\Checklist\Factories\ChecklistShortDtoFactory;
use App\Services\RemindTask\Dtos\RemindTaskDto;
use App\Services\Task\Factories\TaskDtoFactory;
use Illuminate\Database\Eloquent\Collection;

class RemindTaskDtoFactory
{
    /**
     * @param RemindTask $remindTask
     *
     * @return RemindTaskDto
     */
    public static function createFromModel(RemindTask $remindTask): RemindTaskDto
    {
        $dto            = new RemindTaskDto();
        $dto->taskId    = $remindTask->task_id;
        $dto->userId    = $remindTask->user_id;
        $dto->date      = $remindTask->date->getTimestamp();
        $dto->task      = TaskDtoFactory::createFromModel($remindTask->task);
        $dto->checklist = ChecklistShortDtoFactory::createFromModel($remindTask->task->checklist);

        return $dto;
    }

    /**
     * @param Collection $models
     *
     * @return RemindTaskDto[]
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

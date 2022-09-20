<?php

namespace App\Services\DayTask\Factories;

use App\Models\DayTask;
use App\Services\Checklist\Factories\ChecklistShortDtoFactory;
use App\Services\DayTask\Dtos\DayTaskDto;
use App\Services\Task\Factories\TaskDtoFactory;
use Illuminate\Database\Eloquent\Collection;

class DayTaskDtoFactory
{
    /**
     * @param DayTask $dayTask
     *
     * @return DayTaskDto
     */
    public static function createFromModel(DayTask $dayTask): DayTaskDto
    {
        $dto            = new DayTaskDto();
        $dto->id        = $dayTask->id;
        $dto->userId    = $dayTask->user_id;
        $dto->task      = TaskDtoFactory::createFromModel($dayTask->task);
        $dto->checklist = ChecklistShortDtoFactory::createFromModel($dayTask->task->checklist);

        return $dto;
    }

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
}

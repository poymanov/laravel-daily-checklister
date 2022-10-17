<?php

namespace App\Services\PlanTask\Factories;

use App\Models\PlanTask;
use App\Services\Checklist\Factories\ChecklistShortDtoFactory;
use App\Services\PlanTask\Dtos\PlanTaskDto;
use App\Services\Task\Factories\TaskDtoFactory;
use Illuminate\Database\Eloquent\Collection;

class PlanTaskDtoFactory
{
    /**
     * @param PlanTask $planTask
     *
     * @return PlanTaskDto
     */
    public static function createFromModel(PlanTask $planTask): PlanTaskDto
    {
        $dto            = new PlanTaskDto();
        $dto->id        = $planTask->id;
        $dto->userId    = $planTask->user_id;
        $dto->date      = $planTask->date;
        $dto->task      = TaskDtoFactory::createFromModel($planTask->task);
        $dto->checklist = ChecklistShortDtoFactory::createFromModel($planTask->task->checklist);

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

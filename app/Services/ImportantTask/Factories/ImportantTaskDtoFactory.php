<?php

namespace App\Services\ImportantTask\Factories;

use App\Models\ImportantTask;
use App\Services\Checklist\Factories\ChecklistShortDtoFactory;
use App\Services\ImportantTask\Dtos\ImportantTaskDto;
use App\Services\Task\Factories\TaskDtoFactory;
use Illuminate\Database\Eloquent\Collection;

class ImportantTaskDtoFactory
{
    /**
     * @param ImportantTask $importantTask
     *
     * @return ImportantTaskDto
     */
    public static function createFromModel(ImportantTask $importantTask): ImportantTaskDto
    {
        $dto            = new ImportantTaskDto();
        $dto->id        = $importantTask->id;
        $dto->userId    = $importantTask->user_id;
        $dto->task      = TaskDtoFactory::createFromModel($importantTask->task);
        $dto->checklist = ChecklistShortDtoFactory::createFromModel($importantTask->task->checklist);

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

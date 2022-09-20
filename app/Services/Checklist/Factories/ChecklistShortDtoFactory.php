<?php

namespace App\Services\Checklist\Factories;

use App\Models\Checklist;
use App\Services\Checklist\Dtos\ChecklistShortDto;
use Illuminate\Database\Eloquent\Collection;

class ChecklistShortDtoFactory
{
    /**
     * @param Checklist $checklist
     *
     * @return ChecklistShortDto
     */
    public static function createFromModel(Checklist $checklist): ChecklistShortDto
    {
        $dto                   = new ChecklistShortDto();
        $dto->id               = $checklist->id;
        $dto->name             = $checklist->name;
        $dto->checklistGroupId = $checklist->checklist_group_id;

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

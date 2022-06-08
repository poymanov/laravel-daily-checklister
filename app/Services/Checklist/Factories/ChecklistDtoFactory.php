<?php

namespace App\Services\Checklist\Factories;

use App\Models\Checklist;
use App\Services\Checklist\Dtos\ChecklistDto;
use Illuminate\Database\Eloquent\Collection;

class ChecklistDtoFactory
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
     * @param Checklist $checklist
     *
     * @return ChecklistDto
     */
    public static function createFromModel(Checklist $checklist): ChecklistDto
    {
        $dto                   = new ChecklistDto();
        $dto->id               = $checklist->id;
        $dto->name             = $checklist->name;
        $dto->checklistGroupId = $checklist->checklist_group_id;

        return $dto;
    }
}

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
     * @param Checklist $checklistGroup
     *
     * @return ChecklistDto
     */
    public static function createFromModel(Checklist $checklistGroup): ChecklistDto
    {
        $dto       = new ChecklistDto();
        $dto->id   = $checklistGroup->id;
        $dto->name = $checklistGroup->name;

        return $dto;
    }
}

<?php

namespace App\Services\ChecklistGroup\Factories;

use App\Models\ChecklistGroup;
use App\Services\Checklist\Factories\ChecklistDtoFactory;
use App\Services\ChecklistGroup\Dtos\ChecklistGroupDto;
use Illuminate\Database\Eloquent\Collection;

class ChecklistGroupDtoFactory
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
     * @param ChecklistGroup $checklistGroup
     *
     * @return ChecklistGroupDto
     */
    public static function createFromModel(ChecklistGroup $checklistGroup): ChecklistGroupDto
    {
        $dto             = new ChecklistGroupDto();
        $dto->id         = $checklistGroup->id;
        $dto->name       = $checklistGroup->name;
        $dto->checklists = ChecklistDtoFactory::createFromModelsList($checklistGroup->checklists);

        return $dto;
    }
}

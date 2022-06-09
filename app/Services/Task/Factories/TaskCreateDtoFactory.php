<?php

namespace App\Services\Task\Factories;

use App\Services\Task\Dtos\TaskCreateDto;

class TaskCreateDtoFactory
{
    /**
     * @param int    $checklistId
     * @param string $name
     * @param string $description
     *
     * @return TaskCreateDto
     */
    public static function createFromParams(int $checklistId, string $name, string $description): TaskCreateDto
    {
        $dto              = new TaskCreateDto();
        $dto->checklistId = $checklistId;
        $dto->name        = $name;
        $dto->description = $description;

        return $dto;
    }
}

<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\PlanTask;

class PlanTaskBuilder
{
    /**
     * Создание сущности {@see PlanTask}
     *
     * @param array $params Параметры нового объекта
     *
     * @return PlanTask
     */
    public function create(array $params = []): PlanTask
    {
        return PlanTask::factory()->create($params);
    }
}

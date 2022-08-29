<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\DayTask;

class DayTaskBuilder
{
    /**
     * Создание сущности {@see DayTask}
     *
     * @param array $params Параметры нового объекта
     *
     * @return DayTask
     */
    public function create(array $params = []): DayTask
    {
        return DayTask::factory()->create($params);
    }
}

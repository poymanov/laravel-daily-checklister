<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ImportantTask;

class ImportantTaskBuilder
{
    /**
     * Создание сущности {@see ImportantTask}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ImportantTask
     */
    public function create(array $params = []): ImportantTask
    {
        return ImportantTask::factory()->create($params);
    }
}

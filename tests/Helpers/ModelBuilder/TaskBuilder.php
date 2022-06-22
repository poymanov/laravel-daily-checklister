<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Task;

class TaskBuilder
{
    /**
     * Создание сущности {@see Task}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Task
     */
    public function create(array $params = []): Task
    {
        return Task::factory()->createOneQuietly($params);
    }
}

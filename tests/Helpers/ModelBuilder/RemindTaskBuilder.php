<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\RemindTask;

class RemindTaskBuilder
{
    /**
     * Создание сущности {@see RemindTask}
     *
     * @param array $params Параметры нового объекта
     *
     * @return RemindTask
     */
    public function create(array $params = []): RemindTask
    {
        return RemindTask::factory()->createOneQuietly($params);
    }
}

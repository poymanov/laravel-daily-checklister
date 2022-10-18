<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\TaskNote;

class TaskNoteBuilder
{
    /**
     * Создание сущности {@see TaskNote}
     *
     * @param array $params Параметры нового объекта
     *
     * @return TaskNote
     */
    public function create(array $params = []): TaskNote
    {
        return TaskNote::factory()->createOneQuietly($params);
    }
}

<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Checklist;

class ChecklistBuilder
{
    /**
     * Создание сущности {@see Checklist}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Checklist
     */
    public function create(array $params = []): Checklist
    {
        return Checklist::factory()->create($params);
    }
}

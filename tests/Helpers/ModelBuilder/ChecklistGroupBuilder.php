<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\ChecklistGroup;

class ChecklistGroupBuilder
{
    /**
     * Создание сущности {@see ChecklistGroup}
     *
     * @param array $params Параметры нового объекта
     *
     * @return ChecklistGroup
     */
    public function create(array $params = []): ChecklistGroup
    {
        return ChecklistGroup::factory()->create($params);
    }
}

<?php

namespace Tests\Helpers\ModelBuilder;

use App\Models\Page;

class PageBuilder
{
    /**
     * Создание сущности {@see Page} без записи
     *
     * @param array $params Параметры нового объекта
     *
     * @return Page
     */
    public function make(array $params = []): Page
    {
        return Page::factory()->makeOne($params);
    }

    /**
     * Создание сущности {@see Page}
     *
     * @param array $params Параметры нового объекта
     *
     * @return Page
     */
    public function create(array $params = []): Page
    {
        return Page::factory()->create($params);
    }
}

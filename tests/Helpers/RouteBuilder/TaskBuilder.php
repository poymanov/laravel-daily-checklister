<?php

namespace Tests\Helpers\RouteBuilder;

class TaskBuilder
{
    /**
     * @param int $checklistId
     *
     * @return string
     */
    public function create(int $checklistId): string
    {
        return '/admin/checklists/' . $checklistId . '/tasks/create';
    }

    /**
     * @param int $checklistId
     *
     * @return string
     */
    public function store(int $checklistId): string
    {
        return '/admin/checklists/' . $checklistId . '/tasks';
    }
}

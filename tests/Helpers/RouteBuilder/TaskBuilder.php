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
        return '/checklists/' . $checklistId . '/tasks/create';
    }

    /**
     * @param int $checklistId
     *
     * @return string
     */
    public function store(int $checklistId): string
    {
        return '/checklists/' . $checklistId . '/tasks';
    }

    /**
     * @param int $checklistId
     * @param int $taskId
     *
     * @return string
     */
    public function edit(int $checklistId, int $taskId): string
    {
        return '/checklists/' . $checklistId . '/tasks/' . $taskId . '/edit';
    }

    /**
     * @param int $checklistId
     * @param int $taskId
     *
     * @return string
     */
    public function update(int $checklistId, int $taskId): string
    {
        return '/checklists/' . $checklistId . '/tasks/' . $taskId;
    }

    /**
     * @param int $checklistId
     * @param int $taskId
     *
     * @return string
     */
    public function delete(int $checklistId, int $taskId): string
    {
        return '/checklists/' . $checklistId . '/tasks/' . $taskId;
    }
}

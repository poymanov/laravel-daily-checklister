<?php

namespace Tests\Helpers\RouteBuilder;

class ChecklistBuilder
{
    public ChecklistGroupBuilder $checklistGroupBuilder;

    /**
     * @param ChecklistGroupBuilder $checklistGroupBuilder
     */
    public function __construct(ChecklistGroupBuilder $checklistGroupBuilder)
    {
        $this->checklistGroupBuilder = $checklistGroupBuilder;
    }

    /**
     * @param int $checklistGroupId
     *
     * @return string
     */
    public function create(int $checklistGroupId): string
    {
        return $this->checklistGroupBuilder->view($checklistGroupId) . '/checklists/create';
    }

    /**
     * @param int $checklistGroupId
     * @param int $checklistId
     *
     * @return string
     */
    public function edit(int $checklistGroupId, int $checklistId): string
    {
        return $this->view($checklistGroupId, $checklistId) . '/edit';
    }

    /**
     * @param int $checklistGroupId
     *
     * @return string
     */
    public function store(int $checklistGroupId): string
    {
        return $this->checklistGroupBuilder->view($checklistGroupId) . '/checklists/';
    }

    /**
     * @param int $checklistGroupId
     * @param int $checklistId
     *
     * @return string
     */
    public function view(int $checklistGroupId, int $checklistId): string
    {
        return $this->checklistGroupBuilder->view($checklistGroupId) . '/checklists/' . $checklistId;
    }

    /**
     * @param int $checklistGroupId
     * @param int $checklistId
     *
     * @return string
     */
    public function update(int $checklistGroupId, int $checklistId): string
    {
        return $this->checklistGroupBuilder->view($checklistGroupId) . '/checklists/' . $checklistId;
    }

    /**
     * @param int $checklistGroupId
     * @param int $checklistId
     *
     * @return string
     */
    public function delete(int $checklistGroupId, int $checklistId): string
    {
        return $this->checklistGroupBuilder->view($checklistGroupId) . '/checklists/' . $checklistId;
    }
}

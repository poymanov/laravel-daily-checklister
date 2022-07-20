<?php

namespace Tests\Helpers\RouteBuilder;

class ChecklistGroupBuilder
{
    /**
     * @return string
     */
    public function common(): string
    {
        return '/checklist-groups';
    }

    public function create()
    {
        return $this->common() . '/create';
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function view(int $id): string
    {
        return $this->common() . '/' . $id;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function update(int $id): string
    {
        return $this->common() . '/' . $id;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function delete(int $id): string
    {
        return $this->common() . '/' . $id;
    }

    /**
     * @param int $id
     *
     * @return string
     */
    public function edit(int $id): string
    {
        return $this->common() . '/' . $id . '/edit';
    }
}

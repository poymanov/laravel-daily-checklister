<?php

namespace Tests\Helpers\RouteBuilder;

class PageBuilder
{
    /**
     * @return string
     */
    public function create(): string
    {
        return $this->common() . '/create';
    }

    /**
     * @return string
     */
    public function store(): string
    {
        return $this->common();
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
    public function edit(int $id): string
    {
        return $this->common() . '/' . $id . '/edit';
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
     * @return string
     */
    private function common(): string
    {
        return '/admin/pages';
    }
}

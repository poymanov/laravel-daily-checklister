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
     * @return string
     */
    private function common(): string
    {
        return '/admin/pages';
    }
}

<?php

namespace Tests\Helpers\RouteBuilder;

class ImportantTaskBuilder
{
    /**
     * @return string
     */
    public function index(): string
    {
        return '/tasks/important';
    }

    /**
     * @param int $taskId
     *
     * @return string
     */
    public function delete(int $taskId): string
    {
        return '/tasks/important/' . $taskId;
    }
}

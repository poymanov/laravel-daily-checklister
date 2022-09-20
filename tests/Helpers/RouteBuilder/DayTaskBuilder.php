<?php

namespace Tests\Helpers\RouteBuilder;

class DayTaskBuilder
{
    /**
     * @return string
     */
    public function index(): string
    {
        return '/tasks/day';
    }

    /**
     * @param int $taskId
     *
     * @return string
     */
    public function delete(int $taskId): string
    {
        return '/tasks/day/' . $taskId;
    }
}

<?php

namespace Tests\Helpers\RouteBuilder;

class PlanTaskBuilder
{
    /**
     * @return string
     */
    public function index(): string
    {
        return '/tasks/plan';
    }

    /**
     * @param int $taskId
     *
     * @return string
     */
    public function delete(int $taskId): string
    {
        return '/tasks/plan/' . $taskId;
    }
}

<?php

namespace App\Services\Task\Dtos;

class TaskDto
{
    public int $id;

    public string $name;

    public int $order;

    public string $description;

    public bool $completed;
}

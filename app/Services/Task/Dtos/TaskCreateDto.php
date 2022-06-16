<?php

namespace App\Services\Task\Dtos;

class TaskCreateDto
{
    public int $checklistId;

    public string $name;

    public string $description;

    public int $order;
}

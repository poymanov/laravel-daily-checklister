<?php

namespace App\Services\TaskNote\Dtos;

class TaskNoteCreateUpdateDto
{
    /** @var int */
    public int $taskId;

    /** @var int */
    public int $userId;

    /** @var string */
    public string $text;
}

<?php

namespace App\Services\Task\Exceptions;

use Exception;

class TaskNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Task not found: ' . $id;

        parent::__construct($message);
    }
}

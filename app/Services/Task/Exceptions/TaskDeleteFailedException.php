<?php

namespace App\Services\Task\Exceptions;

use Exception;

class TaskDeleteFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to delete task: ' . $id;

        parent::__construct($message);
    }
}

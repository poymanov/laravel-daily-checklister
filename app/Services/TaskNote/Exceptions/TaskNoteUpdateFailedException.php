<?php

namespace App\Services\TaskNote\Exceptions;

use Exception;

class TaskNoteUpdateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to update task note';

        parent::__construct($message);
    }
}

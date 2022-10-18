<?php

namespace App\Services\TaskNote\Exceptions;

use Exception;

class TaskNoteCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create task note';

        parent::__construct($message);
    }
}

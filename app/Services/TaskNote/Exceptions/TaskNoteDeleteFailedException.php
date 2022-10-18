<?php

namespace App\Services\TaskNote\Exceptions;

use Exception;

class TaskNoteDeleteFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to remove task note';

        parent::__construct($message);
    }
}

<?php

namespace App\Services\TaskNote\Exceptions;

use Exception;

class TaskNoteNotFoundException extends Exception
{
    public function __construct()
    {
        $message = 'Task note not found';

        parent::__construct($message);
    }
}

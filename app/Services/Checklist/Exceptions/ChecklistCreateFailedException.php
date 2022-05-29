<?php

namespace App\Services\Checklist\Exceptions;

use Exception;

class ChecklistCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create checklist';

        parent::__construct($message);
    }
}

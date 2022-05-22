<?php

namespace App\Services\ChecklistGroup\Exceptions;

use Exception;

class ChecklistGroupCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create checklist group';

        parent::__construct($message);
    }
}

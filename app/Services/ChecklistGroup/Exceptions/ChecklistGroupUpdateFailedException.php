<?php

namespace App\Services\ChecklistGroup\Exceptions;

use Exception;

class ChecklistGroupUpdateFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to update checklist group: ' . $id;

        parent::__construct($message);
    }
}

<?php

namespace App\Services\ChecklistGroup\Exceptions;

use Exception;

class ChecklistGroupDeleteFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to delete checklist group: ' . $id;

        parent::__construct($message);
    }
}

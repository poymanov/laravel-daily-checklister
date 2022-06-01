<?php

namespace App\Services\Checklist\Exceptions;

use Exception;

class ChecklistDeleteFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to delete checklist: ' . $id;

        parent::__construct($message);
    }
}

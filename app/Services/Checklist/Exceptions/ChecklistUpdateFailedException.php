<?php

namespace App\Services\Checklist\Exceptions;

use Exception;

class ChecklistUpdateFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to update checklist: ' . $id;

        parent::__construct($message);
    }
}

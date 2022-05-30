<?php

namespace App\Services\Checklist\Exceptions;

use Exception;

class ChecklistNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Checklist not found: ' . $id;

        parent::__construct($message);
    }
}

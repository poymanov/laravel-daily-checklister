<?php

namespace App\Services\ChecklistGroup\Exceptions;

use Exception;

class ChecklistGroupNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Checklist group not found: ' . $id;

        parent::__construct($message);
    }
}

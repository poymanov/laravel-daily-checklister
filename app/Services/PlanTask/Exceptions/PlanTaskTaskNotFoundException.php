<?php

namespace App\Services\PlanTask\Exceptions;

use Exception;

class PlanTaskTaskNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Failed to find task: ' . $id;

        parent::__construct($message);
    }
}

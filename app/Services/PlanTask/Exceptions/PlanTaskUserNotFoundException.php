<?php

namespace App\Services\PlanTask\Exceptions;

use Exception;

class PlanTaskUserNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Failed to find user: ' . $id;

        parent::__construct($message);
    }
}

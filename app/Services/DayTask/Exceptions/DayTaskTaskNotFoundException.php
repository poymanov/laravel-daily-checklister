<?php

namespace App\Services\DayTask\Exceptions;

use Exception;

class DayTaskTaskNotFoundException extends Exception
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

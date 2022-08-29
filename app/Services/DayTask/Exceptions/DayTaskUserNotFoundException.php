<?php

namespace App\Services\DayTask\Exceptions;

use Exception;

class DayTaskUserNotFoundException extends Exception
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

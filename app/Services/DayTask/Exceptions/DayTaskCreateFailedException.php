<?php

namespace App\Services\DayTask\Exceptions;

use Exception;

class DayTaskCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to remove day task';

        parent::__construct($message);
    }
}

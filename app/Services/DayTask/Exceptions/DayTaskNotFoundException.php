<?php

namespace App\Services\DayTask\Exceptions;

use Exception;

class DayTaskNotFoundException extends Exception
{
    public function __construct()
    {
        $message = 'Day task not found';

        parent::__construct($message);
    }
}

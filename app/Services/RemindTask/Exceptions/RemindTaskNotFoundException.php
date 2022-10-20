<?php

namespace App\Services\RemindTask\Exceptions;

use Exception;

class RemindTaskNotFoundException extends Exception
{
    public function __construct()
    {
        $message = 'Task reminder not found';

        parent::__construct($message);
    }
}

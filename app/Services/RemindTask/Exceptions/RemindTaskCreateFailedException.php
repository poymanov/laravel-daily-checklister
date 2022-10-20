<?php

namespace App\Services\RemindTask\Exceptions;

use Exception;

class RemindTaskCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create task reminder';

        parent::__construct($message);
    }
}

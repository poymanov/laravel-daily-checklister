<?php

namespace App\Services\RemindTask\Exceptions;

use Exception;

class RemindTaskDeleteFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to delete task reminder';

        parent::__construct($message);
    }
}

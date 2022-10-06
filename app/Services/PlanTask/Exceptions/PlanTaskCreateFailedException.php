<?php

namespace App\Services\PlanTask\Exceptions;

use Exception;

class PlanTaskCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create plan task';

        parent::__construct($message);
    }
}

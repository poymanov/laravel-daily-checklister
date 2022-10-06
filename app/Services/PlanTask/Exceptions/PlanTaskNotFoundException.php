<?php

namespace App\Services\PlanTask\Exceptions;

use Exception;

class PlanTaskNotFoundException extends Exception
{
    public function __construct()
    {
        $message = 'Plan task not found';

        parent::__construct($message);
    }
}

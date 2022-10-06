<?php

namespace App\Services\PlanTask\Exceptions;

use Exception;

class PlanTaskDeleteFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to delete plan task';

        parent::__construct($message);
    }
}

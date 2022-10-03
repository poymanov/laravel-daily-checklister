<?php

namespace App\Services\ImportantTask\Exceptions;

use Exception;

class ImportantTaskCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create important task';

        parent::__construct($message);
    }
}

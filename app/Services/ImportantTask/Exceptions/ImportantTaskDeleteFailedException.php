<?php

namespace App\Services\ImportantTask\Exceptions;

use Exception;

class ImportantTaskDeleteFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to delete important task';

        parent::__construct($message);
    }
}

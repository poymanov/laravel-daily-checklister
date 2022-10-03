<?php

namespace App\Services\ImportantTask\Exceptions;

use Exception;

class ImportantTaskNotFoundException extends Exception
{
    public function __construct()
    {
        $message = 'Important task not found';

        parent::__construct($message);
    }
}

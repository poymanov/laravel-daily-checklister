<?php

namespace App\Services\Page\Exceptions;

use Exception;

class PageCreateFailedException extends Exception
{
    public function __construct()
    {
        $message = 'Failed to create page';

        parent::__construct($message);
    }
}

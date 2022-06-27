<?php

namespace App\Services\Page\Exceptions;

use Exception;

class PageDeleteFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to delete page: ' . $id;

        parent::__construct($message);
    }
}

<?php

namespace App\Services\Page\Exceptions;

use Exception;

class PageUpdateFailedException extends Exception
{
    public function __construct(int $id)
    {
        $message = 'Failed to update page: ' . $id;

        parent::__construct($message);
    }
}

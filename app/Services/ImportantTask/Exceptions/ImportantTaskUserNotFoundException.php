<?php

namespace App\Services\ImportantTask\Exceptions;

use Exception;

class ImportantTaskUserNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Failed to find user: ' . $id;

        parent::__construct($message);
    }
}

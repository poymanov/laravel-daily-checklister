<?php

namespace App\Services\ImportantTask\Exceptions;

use Exception;

class ImportantTaskTaskNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Failed to find task: ' . $id;

        parent::__construct($message);
    }
}

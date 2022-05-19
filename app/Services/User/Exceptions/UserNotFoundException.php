<?php

namespace App\Services\User\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $message = 'User not found: ' . implode($params);

        parent::__construct($message);
    }
}

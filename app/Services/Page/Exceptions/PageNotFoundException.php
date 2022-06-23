<?php

namespace App\Services\Page\Exceptions;

use Exception;

class PageNotFoundException extends Exception
{
    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $message = 'Page not found: ' . $id;

        parent::__construct($message);
    }
}

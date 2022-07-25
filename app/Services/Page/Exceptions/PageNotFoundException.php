<?php

namespace App\Services\Page\Exceptions;

use Exception;

class PageNotFoundException extends Exception
{
    /**
     * @param int|null    $id
     * @param string|null $type
     */
    public function __construct(int $id = null, string $type = null)
    {
        $messageTemplate = 'Page not found';

        if ($id) {
            $message = $messageTemplate . ':' . $id;
        } elseif ($type) {
            $message = $messageTemplate . ':' . $type;
        } else {
            $message = $messageTemplate;
        }


        parent::__construct($message);
    }
}

<?php

namespace App\Services\Subscription\Exception;

use Exception;

class SubscriptionNotFoundException extends Exception
{
    public function __construct()
    {
        $message = 'Subscription not found';

        parent::__construct($message);
    }
}

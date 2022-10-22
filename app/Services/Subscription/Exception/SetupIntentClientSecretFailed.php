<?php

namespace App\Services\Subscription\Exception;

use Exception;

class SetupIntentClientSecretFailed extends Exception
{
    public function __construct()
    {
        $message = 'Failed to get setup intent client secret';

        parent::__construct($message);
    }
}

<?php

namespace Tests\Helpers\RouteBuilder;

class SubscriptionBuilder
{
    /**
     * @return string
     */
    public function create(): string
    {
        return '/subscription';
    }

    /**
     * @return string
     */
    public function store(): string
    {
        return '/subscription';
    }
}

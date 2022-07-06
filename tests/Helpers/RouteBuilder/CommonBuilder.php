<?php

namespace Tests\Helpers\RouteBuilder;

class CommonBuilder
{
    /**
     * @return string
     */
    public function home(): string
    {
        return '/';
    }

    /**
     * @return string
     */
    public function consultation(): string
    {
        return '/get-consultation';
    }
}

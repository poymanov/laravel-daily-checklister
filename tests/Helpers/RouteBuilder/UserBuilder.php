<?php

namespace Tests\Helpers\RouteBuilder;

class UserBuilder
{
    public function index(): string
    {
        return '/admin/users';
    }
}

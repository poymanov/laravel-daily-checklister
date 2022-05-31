<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $this->get(routeBuilderHelper()->auth->register())->assertOk();
});

test('new users can register', function () {
    $response = $this->post(routeBuilderHelper()->auth->register(), [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

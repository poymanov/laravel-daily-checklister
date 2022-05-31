<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('login screen can be rendered', function () {
    $this->get(routeBuilderHelper()->auth->login())->assertOk();
});

test('users can authenticate using the login screen', function () {
    $user = modelBuilderHelper()->user->create();

    $response = $this->post(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(RouteServiceProvider::HOME);
});

test('users can not authenticate with invalid password', function () {
    $user = modelBuilderHelper()->user->create();

    $this->post(routeBuilderHelper()->auth->login(), [
        'email'    => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $this->get(routeBuilderHelper()->auth->register())->assertOk();
});

test('wrong website', function () {
    $this->post(routeBuilderHelper()->auth->register(), ['website' => 'test'])->assertSessionHasErrors(['website']);
});

test('new users can register', function () {
    $response = $this->post(routeBuilderHelper()->auth->register(), [
        'name'                  => 'Test User',
        'email'                 => 'test@example.com',
        'password'              => 'password',
        'password_confirmation' => 'password',
        'website'               => 'https://test.ru',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

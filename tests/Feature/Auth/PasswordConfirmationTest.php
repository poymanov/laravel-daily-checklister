<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('confirm password screen can be rendered', function () {
    $user = modelBuilderHelper()->user->create();

    $this->actingAs($user)->get(routeBuilderHelper()->auth->confirmPassword())->assertOk();
});

test('password can be confirmed', function () {
    $user = modelBuilderHelper()->user->create();

    $response = $this->actingAs($user)->post(routeBuilderHelper()->auth->confirmPassword(), [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = modelBuilderHelper()->user->create();

    $response = $this->actingAs($user)->post(routeBuilderHelper()->auth->confirmPassword(), [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

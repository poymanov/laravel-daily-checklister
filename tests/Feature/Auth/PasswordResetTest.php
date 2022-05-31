<?php

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reset password link screen can be rendered', function () {
    $this->get(routeBuilderHelper()->auth->forgotPassword())->assertOk();
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = modelBuilderHelper()->user->create();

    $this->post(routeBuilderHelper()->auth->forgotPassword(), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = modelBuilderHelper()->user->create();

    $this->post(routeBuilderHelper()->auth->forgotPassword(), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get(routeBuilderHelper()->auth->resetPassword() . '/' . $notification->token);

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = modelBuilderHelper()->user->create();

    $this->post(routeBuilderHelper()->auth->forgotPassword(), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post(routeBuilderHelper()->auth->resetPassword(), [
            'token'                 => $notification->token,
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});

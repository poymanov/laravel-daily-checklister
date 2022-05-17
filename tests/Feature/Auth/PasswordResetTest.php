<?php

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reset password link screen can be rendered', function () {
    $response = $this->get(FORGOT_PASSWORD_URL);

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = createUser();

    $this->post(FORGOT_PASSWORD_URL, ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = createUser();

    $this->post(FORGOT_PASSWORD_URL, ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get(RESET_PASSWORD_URL . '/' . $notification->token);

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = createUser();

    $this->post(FORGOT_PASSWORD_URL, ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post(RESET_PASSWORD_URL, [
            'token'                 => $notification->token,
            'email'                 => $user->email,
            'password'              => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});

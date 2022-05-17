<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('confirm password screen can be rendered', function () {
    $user = createUser();

    $response = $this->actingAs($user)->get(CONFIRM_PASSWORD_URL);

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = createUser();

    $response = $this->actingAs($user)->post(CONFIRM_PASSWORD_URL, [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = createUser();

    $response = $this->actingAs($user)->post(CONFIRM_PASSWORD_URL, [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});

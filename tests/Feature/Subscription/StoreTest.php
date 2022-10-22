<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $response = $this->post(routeBuilderHelper()->subscription->store());
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения администратором */
test('admin', function () {
    authHelper()->signInAsAdmin();

    $response = $this->post(routeBuilderHelper()->subscription->store());
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

/** Попытка создания с пустыми данными */
test('empty', function () {
    authHelper()->signIn();

    $response = $this->post(routeBuilderHelper()->subscription->store());
    $response->assertSessionHasErrors(['name', 'plan']);
});

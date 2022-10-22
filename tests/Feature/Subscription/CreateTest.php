<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $response = $this->get(routeBuilderHelper()->subscription->create());
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения администратором */
test('admin', function () {
    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->subscription->create());
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

/** Успешное открытие страницы */
test('success', function () {
    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->subscription->create());
    $response->assertOk();

    $response->assertSee('Card Holder Name');
    $response->assertSee('Credit or debit card');
});

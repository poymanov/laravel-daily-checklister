<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $this->get(routeBuilderHelper()->page->create())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    authHelper()->signIn();

    $this->get(routeBuilderHelper()->page->create())->assertForbidden();
});

/** Успешное отображение формы создания */
test('success', function () {
    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->page->create());
    $response->assertOk();

    $response->assertSee('New Page');
    $response->assertSee('Title');
    $response->assertSee('Content');
    $response->assertSee('Save');
});

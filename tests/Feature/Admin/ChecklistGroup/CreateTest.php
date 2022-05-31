<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $this
        ->get(routeBuilderHelper()->checklistGroup->create())
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    authHelper()->signIn();

    $this
        ->get(routeBuilderHelper()->checklistGroup->create())
        ->assertForbidden();
});

/** Успешное отображение формы создания */
test('success', function () {
    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklistGroup->create());
    $response->assertOk();

    $response->assertSee('New Checklist Group');
    $response->assertSee('Name');
    $response->assertSee('Save');
});

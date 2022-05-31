<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    $this->get(routeBuilderHelper()->checklistGroup->edit($checklistGroup->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $this->get(routeBuilderHelper()->checklistGroup->edit($checklistGroup->id))->assertForbidden();
});

/** Успешное отображение формы редактирования */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklistGroup->edit($checklistGroup->id));
    $response->assertOk();

    $response->assertSee('Edit Checklist Group');
    $response->assertSee('Name');
    $response->assertSee('Save');
});

<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    $this->get(routeBuilderHelper()->checklist->create($checklistGroup->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $this->get(routeBuilderHelper()->checklist->create($checklistGroup->id))->assertForbidden();
});

/** Попытка создания чеклиста для несуществующей группы */
test('not existed group', function () {
    authHelper()->signInAsAdmin();
    $this->get(routeBuilderHelper()->checklist->create(999))->assertNotFound();
});

/** Успешное отображение формы создания */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklist->create($checklistGroup->id));

    $response->assertOk();
    $response->assertSee('New Checklist in ' . $checklistGroup->name);
    $response->assertSee('Name');
    $response->assertSee('Save');
});

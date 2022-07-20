<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $this
        ->get(routeBuilderHelper()->checklist->edit($checklist->group->id, $checklist->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signIn();
    $this
        ->get(routeBuilderHelper()->checklist->edit($checklist->group->id, $checklist->id))
        ->assertForbidden();
});

/** Попытка посещения с несуществующей группой */
test('not existed group', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $this->get(routeBuilderHelper()->checklist->edit(999, $checklist->id))->assertNotFound();
});

/** Попытка посещения несуществующего объекта */
test('not existed', function () {
    $group = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $this->get(routeBuilderHelper()->checklist->edit($group->id, 999))->assertNotFound();
});

/** Успешное отображение формы редактирования */
test('success', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklist->edit($checklist->group->id, $checklist->id));
    $response->assertOk();

    $response->assertSee('Edit Checklist');
    $response->assertSee('Name');
    $response->assertSee($checklist->name);
    $response->assertSee('Save');
});

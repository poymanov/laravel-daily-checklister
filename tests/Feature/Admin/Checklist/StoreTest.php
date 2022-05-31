<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    $this->post(routeBuilderHelper()->checklist->store($checklistGroup->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка создания пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $this->post(routeBuilderHelper()->checklist->store($checklistGroup->id))->assertForbidden();
});

/** Попытка создания для несуществующей группы */
test('not existed group', function () {
    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->checklist->store(999))->assertNotFound();
});

/** Попытка создания без данных */
test('empty', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->checklist->store($checklistGroup->id))->assertSessionHasErrors(['name']);
});

/** Попытка создания с неуникальным названием */
test('not unique name', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->checklist->store($checklistGroup->id), ['name' => $checklist->name])->assertSessionHasErrors(['name']);
});

/** Успешное создание */
test('success', function () {
    $group = modelBuilderHelper()->checklistGroup->create();
    ;

    $name = faker()->word();

    authHelper()->signInAsAdmin();

    $response = $this->post(routeBuilderHelper()->checklist->store($group->id), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist was created');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklists', [
        'name'               => $name,
        'checklist_group_id' => $group->id,
    ]);
});

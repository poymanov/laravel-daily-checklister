<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $this
        ->put(routeBuilderHelper()->checklist->update($checklistGroup->id, $checklist->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signIn();
    $this->put(routeBuilderHelper()->checklist->update($checklistGroup->id, $checklist->id))->assertForbidden();
});

/** Попытка изменения с несуществующей группой */
test('not existed group', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->checklist->update(999, $checklist->id))->assertNotFound();
});

/** Попытка изменения с несуществующего объекта */
test('not existed', function () {
    $group = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->checklist->update($group->id, 999))->assertNotFound();
});

/** Попытка изменения без данных */
test('empty', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->checklist->update($checklistGroup->id, $checklist->id))->assertSessionHasErrors(['name']);
});

/** Попытка изменения с неуникальным названием */
test('not unique name', function () {
    $checklistGroup  = modelBuilderHelper()->checklistGroup->create();
    $checklistFirst  = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $checklistSecond = modelBuilderHelper()->checklist->create();
    ;

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->checklist->update($checklistGroup->id, $checklistFirst->id), ['name' => $checklistSecond->name])
        ->assertSessionHasErrors(['name']);
});

/** Успешное изменение */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $name = faker()->word();

    authHelper()->signInAsAdmin();

    $response = $this->put(routeBuilderHelper()->checklist->update($checklistGroup->id, $checklist->id), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist was updated');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklists', [
        'id'                 => $checklist->id,
        'name'               => $name,
        'checklist_group_id' => $checklist->group->id,
    ]);
});

/** Попытка изменения с такими же данными */
test('success same name', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->checklist->update($checklistGroup->id, $checklist->id), ['name' => $checklist->name])
        ->assertSessionHasNoErrors();
});

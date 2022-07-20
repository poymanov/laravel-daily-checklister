<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    $this
        ->put(routeBuilderHelper()->checklistGroup->update($checklistGroup->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $this
        ->put(routeBuilderHelper()->checklistGroup->update($checklistGroup->id))
        ->assertForbidden();
});

/** Попытка изменения без данных */
test('empty', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $this
        ->put(routeBuilderHelper()->checklistGroup->update($checklistGroup->id))
        ->assertSessionHasErrors(['name']);
});

/** Попытка изменения группы с неуникальным названием */
test('not unique name', function () {
    $name = faker()->word();
    modelBuilderHelper()->checklistGroup->create(['name' => $name]);
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $this
        ->put(routeBuilderHelper()->checklistGroup->update($checklistGroup->id), ['name' => $name])
        ->assertSessionHasErrors(['name']);
});

/** Успешное изменение */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $name           = faker()->word();

    authHelper()->signInAsAdmin();

    $response = $this->put(routeBuilderHelper()->checklistGroup->update($checklistGroup->id), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist group was updated');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklist_groups', [
        'id'   => $checklistGroup->id,
        'name' => $name,
    ]);
});

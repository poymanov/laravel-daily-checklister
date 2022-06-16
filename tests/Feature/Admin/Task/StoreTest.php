<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use function Pest\Faker\faker;

/** Попытка создания гостем */
test('guest', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $this->post(routeBuilderHelper()->task->store($checklist->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка создания пользователем без прав администратора */
test('user', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signIn();

    $this->post(routeBuilderHelper()->task->store($checklist->id))->assertForbidden();
});

/** Попытка создания задачи для несуществующего чеклиста */
test('not existed checklist', function () {
    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->task->store(999))->assertNotFound();
});

/** Попытка создания без данных */
test('empty', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();

    $this->post(routeBuilderHelper()->task->store($checklist->id))->assertSessionHasErrors(['name', 'description']);
});

/** Попытка создания со слишком коротким наименованием */
test('too short name', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();

    $this->post(routeBuilderHelper()->task->store($checklist->id), ['name' => 'te'])->assertSessionHasErrors(['name']);
});

/** Попытка создания со слишком длинным наименованием */
test('too long name', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->task->store($checklist->id), ['name' => faker()->realTextBetween(256, 300)])
        ->assertSessionHasErrors(['name']);
});

/** Попытка создания со слишком коротким описанием */
test('too short description', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->task->store($checklist->id), ['description' => 'te'])->assertSessionHasErrors(['description']);
});

/** Успешное создание задачи */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $name        = faker()->words(3, true);
    $description = faker()->realTextBetween(256, 300);

    authHelper()->signInAsAdmin();

    $response = $this->post(routeBuilderHelper()->task->store($checklist->id), ['name' => $name, 'description' => $description]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Task was created');

    $response->assertRedirect(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));

    $this->assertDatabaseHas('tasks', [
        'name'         => $name,
        'description'  => $description,
        'checklist_id' => $checklist->id,
        'order'        => 1,
    ]);
});

/** Успешное создание задачи с правильным порядком сортировки */
test('success next order position', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 1]);
    modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 2]);

    $name        = faker()->words(3, true);
    $description = faker()->realTextBetween(256, 300);

    authHelper()->signInAsAdmin();

    $this->post(routeBuilderHelper()->task->store($checklist->id), ['name' => $name, 'description' => $description]);

    $this->assertDatabaseHas('tasks', [
        'name'         => $name,
        'description'  => $description,
        'checklist_id' => $checklist->id,
        'order'        => 3,
    ]);
});

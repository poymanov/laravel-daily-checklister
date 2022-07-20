<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    $this->put(routeBuilderHelper()->task->update($checklist->id, $task->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signIn();

    $this->put(routeBuilderHelper()->task->update($checklist->id, $task->id))->assertForbidden();
});

/** Попытка изменения задачи для несуществующего чеклиста */
test('not existed checklist', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->task->update(999, $task->id))->assertNotFound();
});

/** Попытка изменения несуществующей задачи */
test('not existed', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->task->update($checklist->id, 999))->assertNotFound();
});

/** Попытка изменения без данных */
test('empty', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->task->update($checklist->id, $task->id))->assertSessionHasErrors(['name', 'description']);
});

/** Попытка изменения со слишком коротким наименованием */
test('too short name', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->task->update($checklist->id, $task->id), ['name' => 'te'])->assertSessionHasErrors(['name']);
});

/** Попытка изменения со слишком длинным наименованием */
test('too long name', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();

    $this
        ->put(routeBuilderHelper()->task->update($checklist->id, $task->id), ['name' => faker()->realTextBetween(256, 300)])
        ->assertSessionHasErrors(['name']);
});

/** Попытка изменения со слишком коротким описанием */
test('too short description', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();

    $this
        ->put(routeBuilderHelper()->task->update($checklist->id, $task->id), ['description' => 'te'])
        ->assertSessionHasErrors(['description']);
});

/** Успешное изменение задачи */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $task           = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    $name        = faker()->words(3, true);
    $description = faker()->realTextBetween(256, 300);

    authHelper()->signInAsAdmin();

    $response = $this->put(routeBuilderHelper()->task->update($checklist->id, $task->id), ['name' => $name, 'description' => $description]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Task was updated');

    $response->assertRedirect(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));

    $this->assertDatabaseHas('tasks', [
        'id'          => $task->id,
        'name'        => $name,
        'description' => $description,
    ]);
});

/** Успешное изменение задачи с безопасным описанием */
test('success with safe description', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    $name              = faker()->words(3, true);
    $safeDescription   = faker()->realTextBetween(256, 300);
    $unsafeDescription = '<script>alert("test");</script>' . $safeDescription;

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->task->update($checklist->id, $task->id), ['name' => $name, 'description' => $unsafeDescription]);

    $this->assertDatabaseHas('tasks', [
        'id'          => $task->id,
        'description' => $safeDescription,
    ]);
});

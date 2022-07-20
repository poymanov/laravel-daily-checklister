<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    $this->get(routeBuilderHelper()->task->edit($task->id, $task->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signIn();
    $this->get(routeBuilderHelper()->task->edit($task->id, $task->id))->assertForbidden();
});

/** Попытка посещения с несуществующим чеклистом */
test('not existed checklist', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signInAsAdmin();
    $this->get(routeBuilderHelper()->task->edit(999, $task->id))->assertNotFound();
});

/** Попытка посещения несуществующего объекта */
test('not existed', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $this->get(routeBuilderHelper()->task->edit($checklist->id, 999))->assertNotFound();
});

/** Успешное отображение формы редактирования */
test('success', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->task->edit($task->id, $task->id));
    $response->assertOk();

    $response->assertSee('Edit Task');
    $response->assertSee('Name');
    $response->assertSee('Description');
    $response->assertSee($task->name);
    $response->assertSee($task->description);
    $response->assertSee('Save');
});

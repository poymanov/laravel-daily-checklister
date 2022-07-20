<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    $this->get(routeBuilderHelper()->task->create($checklist->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signIn();
    $this->get(routeBuilderHelper()->task->create($checklist->id))->assertForbidden();
});


/** Попытка просмотра создания задачи для несуществующего чеклиста */
test('not existed checklist', function () {
    authHelper()->signInAsAdmin();
    $this->get(routeBuilderHelper()->task->create(999))->assertNotFound();
});

/** Успешное отображение формы создания */
test('success', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->task->create($checklist->id));
    $response->assertOk();

    $response->assertSee('New Task in ' . $checklist->name);
    $response->assertSee('Name');
    $response->assertSee('Description');
    $response->assertSee('Save');
});

<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Отображение кнопки удаления на странице редактирования */
test('button', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklistGroup->edit($checklistGroup->id));
    $response->assertOk();

    $response->assertSee('Delete');
});

/** Попытка изменения гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    $this
        ->delete(routeBuilderHelper()->checklistGroup->delete($checklistGroup->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $response = $this->delete(routeBuilderHelper()->checklistGroup->delete($checklistGroup->id));
    $response->assertForbidden();
});

/** Попытка удаления несуществующего элемента */
test('not existed', function () {
    authHelper()->signInAsAdmin();
    $response = $this->delete(routeBuilderHelper()->checklistGroup->delete(999));
    $response->assertNotFound();
});

/** Успешное удаление */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $response = $this->delete(routeBuilderHelper()->checklistGroup->delete($checklistGroup->id));

    $response->assertSessionHas('alert.success', 'Checklist group was deleted');

    $response->assertRedirect('/');

    $this->assertDatabaseMissing('checklist_groups', [
        'id'         => $checklistGroup->id,
        'deleted_at' => null,
    ]);
});

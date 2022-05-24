<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Отображение кнопки удаления на странице редактирования */
test('button', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $response = $this->get(makeChecklistGroupDeleteUrl($checklistGroup->id) . '/edit');
    $response->assertOk();

    $response->assertSee('Delete');
});

/** Попытка изменения гостем */
test('guest', function () {
    $checklistGroup = createChecklistGroup();

    $response = $this->delete(makeChecklistGroupDeleteUrl($checklistGroup->id));
    $response->assertRedirect(LOGIN_URL);
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = createChecklistGroup();

    signIn();
    $response = $this->delete(makeChecklistGroupDeleteUrl($checklistGroup->id));
    $response->assertForbidden();
});

/** Попытка удаления несуществующего элемента */
test('not existed', function () {
    signIn(createUser([], true));
    $response = $this->delete(makeChecklistGroupDeleteUrl(999));
    $response->assertNotFound();
});

/** Успешное удаление */
test('success', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $response = $this->delete(makeChecklistGroupDeleteUrl($checklistGroup->id));

    $response->assertSessionHas('alert.success', 'Checklist group was deleted');

    $response->assertRedirect('/');

    $this->assertDatabaseMissing('checklist_groups', [
        'id'         => $checklistGroup->id,
        'deleted_at' => null,
    ]);
});

/**
 * Создание url
 *
 * @param int $id
 *
 * @return string
 */
function makeChecklistGroupDeleteUrl(int $id): string
{
    return ADMIN_CHECKLIST_GROUP_URL . '/' . $id;
}

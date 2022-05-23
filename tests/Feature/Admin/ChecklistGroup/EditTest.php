<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklistGroup = createChecklistGroup();

    $this->get(makeChecklistGroupEditUrl($checklistGroup->id))->assertRedirect(LOGIN_URL);
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = createChecklistGroup();

    signIn();
    $this->get(makeChecklistGroupEditUrl($checklistGroup->id))->assertForbidden();
});

/** Успешное отображение формы редактирования */
test('success', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $response = $this->get(makeChecklistGroupEditUrl($checklistGroup->id));
    $response->assertOk();

    $response->assertSee('Edit Checklist Group');
    $response->assertSee('Name');
    $response->assertSee('Save');
});

/**
 * Создание url
 *
 * @param int $id
 *
 * @return string
 */
function makeChecklistGroupEditUrl(int $id): string
{
    return ADMIN_CHECKLIST_GROUP_URL . '/' . $id . '/edit';
}

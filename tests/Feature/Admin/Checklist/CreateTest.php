<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklistGroup = createChecklistGroup();

    $this->get(makeCreateChecklistUrl($checklistGroup->id))->assertRedirect(LOGIN_URL);
});


/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = createChecklistGroup();

    signIn();
    $this->get(makeCreateChecklistUrl($checklistGroup->id))->assertForbidden();
});

/** Попытка создания чеклиста для несуществующей группы */
test('not existed group', function () {
    signIn(createUser([], true));
    $this->get(makeCreateChecklistUrl(999))->assertNotFound();
});


/** Успешное отображение формы создания */
test('success', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $response = $this->get(makeCreateChecklistUrl($checklistGroup->id));

    $response->assertOk();
    $response->assertSee('New Checklist in ' . $checklistGroup->name);
    $response->assertSee('Name');
    $response->assertSee('Save');
});

/**
 * @param int $checklistGroupId
 *
 * @return string
 */
function makeCreateChecklistUrl(int $checklistGroupId): string
{
    return ADMIN_CHECKLIST_GROUP_URL . '/' . $checklistGroupId . '/checklists/create';
}

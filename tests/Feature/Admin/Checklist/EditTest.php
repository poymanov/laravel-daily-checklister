<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $checklist = createChecklist();

    $this->get(makeEditChecklistUrl($checklist->group->id, $checklist->id))->assertRedirect(LOGIN_URL);
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $checklist = createChecklist();

    signIn();
    $this->get(makeEditChecklistUrl($checklist->group->id, $checklist->id))->assertForbidden();
});


/** Успешное отображение формы редактирования */
test('success', function () {
    $checklist = createChecklist();

    signIn(createUser([], true));
    $response = $this->get(makeEditChecklistUrl($checklist->group->id, $checklist->id));
    $response->assertOk();

    $response->assertSee('Edit Checklist');
    $response->assertSee('Name');
    $response->assertSee($checklist->name);
    $response->assertSee('Save');
});

/**
 * @param int $checklistGroupId
 * @param int $checklistId
 *
 * @return string
 */
function makeEditChecklistUrl(int $checklistGroupId, int $checklistId): string
{
    return '/admin/checklist-groups/' . $checklistGroupId . '/checklists/' . $checklistId . '/edit';
}

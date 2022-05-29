<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $checklistGroup = createChecklistGroup();

    $this->post(makeChecklistStoreUrl($checklistGroup->id))->assertRedirect(LOGIN_URL);
});

/** Попытка создания пользователем без прав администратора */
test('user', function () {
    $checklistGroup = createChecklistGroup();

    signIn();
    $this->post(makeChecklistStoreUrl($checklistGroup->id))->assertForbidden();
});

/** Попытка создания для несуществующей группы */
test('not existed group', function () {
    signIn(createUser([], true));
    $this->post(makeChecklistStoreUrl(999))->assertNotFound();
});

/** Попытка создания без данных */
test('empty', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $this->post(makeChecklistStoreUrl($checklistGroup->id))->assertSessionHasErrors(['name']);
});

/** Попытка создания с неуникальным названием */
test('not unique name', function () {
    $checklistGroup = createChecklistGroup();
    $checklist = createChecklist(['checklist_group_id' => $checklistGroup->id]);

    signIn(createUser([], true));
    $this->post(makeChecklistStoreUrl($checklistGroup->id), ['name' => $checklist->name])->assertSessionHasErrors(['name']);
});

/** Успешное создание */
test('success', function () {
    $group = createChecklistGroup();

    $name = faker()->word();

    signIn(createUser([], true));

    $response = $this->post(makeChecklistStoreUrl($group->id), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist was created');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklists', [
        'name'               => $name,
        'checklist_group_id' => $group->id,
    ]);
});

/**
 * @param int $checklistGroupId
 *
 * @return string
 */
function makeChecklistStoreUrl(int $checklistGroupId): string
{
    return ADMIN_CHECKLIST_GROUP_URL . '/' . $checklistGroupId . '/checklists';
}

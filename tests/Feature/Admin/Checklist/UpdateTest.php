<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $checklistGroup = createChecklistGroup();
    $checklist = createChecklist(['checklist_group_id' => $checklistGroup->id]);

    $this->put(makeUpdateChecklistUrl($checklistGroup->id, $checklist->id))->assertRedirect(LOGIN_URL);
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = createChecklistGroup();
    $checklist = createChecklist(['checklist_group_id' => $checklistGroup->id]);

    signIn();
    $this->put(makeUpdateChecklistUrl($checklistGroup->id, $checklist->id))->assertForbidden();
});

/** Попытка изменения без данных */
test('empty', function () {
    $checklistGroup = createChecklistGroup();
    $checklist = createChecklist(['checklist_group_id' => $checklistGroup->id]);

    signIn(createUser([], true));
    $this->put(makeUpdateChecklistUrl($checklistGroup->id, $checklist->id))->assertSessionHasErrors(['name']);
});

/** Попытка изменения с неуникальным названием */
test('not unique name', function () {
    $checklistGroup = createChecklistGroup();
    $checklistFirst  = createChecklist(['checklist_group_id' => $checklistGroup->id]);
    $checklistSecond = createChecklist();

    signIn(createUser([], true));
    $this->put(makeUpdateChecklistUrl($checklistGroup->id, $checklistFirst->id), ['name' => $checklistSecond->name])->assertSessionHasErrors(['name']);
});

/** Успешное изменение */
test('success', function () {
    $checklistGroup = createChecklistGroup();
    $checklist = createChecklist(['checklist_group_id' => $checklistGroup->id]);

    $name = faker()->word();

    signIn(createUser([], true));

    $response = $this->put(makeUpdateChecklistUrl($checklistGroup->id, $checklist->id), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist was updated');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklists', [
        'id'                 => $checklist->id,
        'name'               => $name,
        'checklist_group_id' => $checklist->group->id,
    ]);
});

/** Попытка изменения с такими же данными */
test('success same name', function () {
    $checklistGroup = createChecklistGroup();
    $checklist = createChecklist(['checklist_group_id' => $checklistGroup->id]);

    signIn(createUser([], true));

    $this->put(makeUpdateChecklistUrl($checklistGroup->id, $checklist->id), ['name' => $checklist->name])->assertSessionHasNoErrors();
});

/**
 * @param int $checklistGroupId
 * @param int $checklistId
 *
 * @return string
 */
function makeUpdateChecklistUrl(int $checklistGroupId, int $checklistId): string
{
    return '/admin/checklist-groups/' . $checklistGroupId . '/checklists/' . $checklistId;
}

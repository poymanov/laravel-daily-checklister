<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $checklistGroup = createChecklistGroup();

    $this->put(makeChecklistGroupUpdateUrl($checklistGroup->id))->assertRedirect(LOGIN_URL);
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $checklistGroup = createChecklistGroup();

    signIn();
    $this->put(makeChecklistGroupUpdateUrl($checklistGroup->id))->assertForbidden();
});

/** Попытка изменения без данных */
test('empty', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $this->put(makeChecklistGroupUpdateUrl($checklistGroup->id))->assertSessionHasErrors(['name']);
});

/** Попытка изменения группы с неуникальным названием */
test('not unique name', function () {
    $name = faker()->word();
    createChecklistGroup(['name' => $name]);
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $this->put(makeChecklistGroupUpdateUrl($checklistGroup->id), ['name' => $name])->assertSessionHasErrors(['name']);
});

/** Успешное изменение */
test('success', function () {
    $checklistGroup = createChecklistGroup();
    $name           = faker()->word();

    signIn(createUser([], true));

    $response = $this->put(makeChecklistGroupUpdateUrl($checklistGroup->id), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist group was updated');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklist_groups', [
        'id'   => $checklistGroup->id,
        'name' => $name,
    ]);
});

/**
 * Создание url
 *
 * @param int $id
 *
 * @return string
 */
function makeChecklistGroupUpdateUrl(int $id): string
{
    return ADMIN_CHECKLIST_GROUP_URL . '/' . $id;
}

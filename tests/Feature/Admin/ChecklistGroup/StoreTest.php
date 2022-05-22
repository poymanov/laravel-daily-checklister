<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $this->post(ADMIN_CHECKLIST_GROUP_URL)->assertRedirect(LOGIN_URL);
});

/** Попытка создания пользователем без прав администратора */
test('user', function () {
    signIn();
    $this->post(ADMIN_CHECKLIST_GROUP_URL)->assertForbidden();
});

/** Попытка создания без данных */
test('empty', function () {
    signIn(createUser([], true));
    $this->post(ADMIN_CHECKLIST_GROUP_URL)->assertSessionHasErrors(['name']);
});


/** Попытка создания группы с неуникальным названием */
test('not unique name', function () {
    $name = faker()->word();
    createChecklistGroup(['name' => $name]);

    signIn(createUser([], true));
    $this->post(ADMIN_CHECKLIST_GROUP_URL, ['name' => $name])->assertSessionHasErrors(['name']);
});


/** Успешное создание */
test('success', function () {
    $name = faker()->word();

    signIn(createUser([], true));

    $response = $this->post(ADMIN_CHECKLIST_GROUP_URL, ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist group was created');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('checklist_groups', [
        'name' => $name,
    ]);
});

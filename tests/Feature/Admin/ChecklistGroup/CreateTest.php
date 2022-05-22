<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $this->get(ADMIN_CHECKLIST_GROUP_CREATE_URL)->assertRedirect(LOGIN_URL);
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    signIn();
    $this->get(ADMIN_CHECKLIST_GROUP_CREATE_URL)->assertForbidden();
});

/** Успешное отображение формы создания */
test('success', function () {
    signIn(createUser([], true));
    $response = $this->get(ADMIN_CHECKLIST_GROUP_CREATE_URL);
    $response->assertOk();

    $response->assertSee('New Checklist Group');
    $response->assertSee('Name');
    $response->assertSee('Save');
});

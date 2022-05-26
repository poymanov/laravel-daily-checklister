<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Пользователь без прав администратора не видит пунктов управления группами чеклистов */
test('not admin', function () {
    $checklistGroup = createChecklistGroup();

    signIn();
    $response = $this->get(HOME_URL);
    $response->assertDontSee('Manage Checklists');
    $response->assertDontSee('New checklist group');
    $response->assertDontSee($checklistGroup->name);
});

/** Успешное посещение авторизованным пользователем */
test('admin', function () {
    $checklistGroup = createChecklistGroup();

    signIn(createUser([], true));
    $response = $this->get(HOME_URL);
    $response->assertSee('Manage Checklists');
    $response->assertSee('New checklist group');
    $response->assertSee($checklistGroup->name);
});

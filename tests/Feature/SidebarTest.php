<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Пользователь без прав администратора не видит пунктов управления группами чеклистов */
test('not admin', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $response = $this->get(routeBuilderHelper()->common->home());
    $response->assertDontSee('Manage Checklists');
    $response->assertDontSee('New checklist group');
    $response->assertDontSee($checklistGroup->name);
});

/** Успешное посещение авторизованным пользователем */
test('admin', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->common->home());
    $response->assertSee('Manage Checklists');
    $response->assertSee('New checklist group');
    $response->assertSee($checklistGroup->name);
});

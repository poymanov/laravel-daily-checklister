<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Не отображаются элементы управления страницами */
test('pages management', function () {
    $page = modelBuilderHelper()->page->create(['type' => 'get-consultation']);

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertDontSee('Manage Pages');
    $response->assertDontSee('New page');
    $response->assertDontSee($page->title);
});

/** Не отображаются элементы управления пользователями */
test('users management', function () {
    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertDontSee('Manage Users');
    $response->assertDontSee('Users List');
});

/** Не отображаются элементы управления группами чеклистов */
test('checklist groups management', function () {
    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertDontSee('Manage Checklists');
    $response->assertDontSee('New checklist group');
});

/** Не отображаются элементы управления чеклистами */
test('checklists management', function () {
    modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertDontSee('Add checklist');
});

/** Отображается группа чеклистов */
test('checklist group', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee($checklistGroup->name);
});

/** Пустая группа чеклистов не отображается */
test('empty checklist group', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertDontSee($checklistGroup->name);
});

/** Отображается чеклист */
test('checklist', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee($checklist->name);
});

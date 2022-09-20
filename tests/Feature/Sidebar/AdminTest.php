<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Основные ссылки */
test('common links', function () {
    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());
    $response->assertSee('Home');
    $response->assertSee('My Day');
});

/** Отображаются элементы управления страницами */
test('pages management', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee('Manage Pages');
    $response->assertSee('New page');
    $response->assertSee($page->title);
});

/** Отображаются элементы управления пользователями */
test('users management', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee('Manage Users');
    $response->assertSee('Users List');
});

/** Отображаются элементы управления группами чеклистов */
test('checklist groups management', function () {
    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee('Manage Checklists');
    $response->assertSee('New checklist group');
});

/** Отображаются элементы управления чеклистами */
test('checklists management', function () {
    modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee('Add checklist');
});

/** Отображается группа чеклистов */
test('checklist group', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee($checklist->group->name);
});

/** Пустая группа чеклистов отображается */
test('empty checklist group', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee($checklistGroup->name);
});

/** Отображается чеклист */
test('checklist', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->common->home());

    $response->assertSee($checklist->name);
});

/** Отображение счетчиков по чеклисту */
test('checklist counters', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    $user = modelBuilderHelper()->user->createAdmin();
    authHelper()->signIn($user);

    modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'completed_by' => $user->id, 'completed_at' => now()]);
    modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    $response = $this->get(routeBuilderHelper()->common->home());
    $response->assertSee('1/2');
});

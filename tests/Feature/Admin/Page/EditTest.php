<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $page = modelBuilderHelper()->page->create();

    $this->get(routeBuilderHelper()->page->edit($page->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signIn();

    $this->get(routeBuilderHelper()->page->edit($page->id))->assertForbidden();
});

/** Попытка просмотра несуществующего объекта */
test('not existed', function () {
    authHelper()->signInAsAdmin();

    $this->get(routeBuilderHelper()->page->edit(999))->assertNotFound();
});

/** Успешное отображение формы редактирования */
test('success', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->page->edit($page->id));
    $response->assertOk();

    $response->assertSee('Edit Page');
    $response->assertSee('Title');
    $response->assertSee('Content');
    $response->assertSee('Type');
    $response->assertSee($page->title);
    $response->assertSee($page->content);
    $response->assertSee($page->type);
    $response->assertSee('Save');
});

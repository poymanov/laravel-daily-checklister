<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка просмотра гостем */
test('guest', function () {
    $page = modelBuilderHelper()->page->create();

    $this->get(routeBuilderHelper()->page->view($page->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка просмотра пользователем без прав администратора */
test('user', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signIn();

    $this->get(routeBuilderHelper()->page->view($page->id))->assertForbidden();
});

/** Попытка просмотра несуществующего объекта */
test('not existed', function () {
    authHelper()->signInAsAdmin();

    $this->get(routeBuilderHelper()->page->view(999))->assertNotFound();
});

/** Успешное открытие страницы просмотра */
test('success', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->page->view($page->id));
    $response->assertOk();

    $response->assertSee($page->title);
    $response->assertSee($page->content);

    $response->assertSee('Edit');
});

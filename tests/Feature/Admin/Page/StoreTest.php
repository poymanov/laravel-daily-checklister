<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $this->post(routeBuilderHelper()->page->store())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка создания пользователем без прав администратора */
test('user', function () {
    authHelper()->signIn();

    $this->post(routeBuilderHelper()->page->store())->assertForbidden();
});

/** Попытка создания без данных */
test('empty', function () {
    authHelper()->signInAsAdmin();

    $this->post(routeBuilderHelper()->page->store())->assertSessionHasErrors(['title', 'content']);
});

/** Попытка создания со слишком коротким заголовком */
test('too short name', function () {
    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->page->store(), ['title' => 'te'])->assertSessionHasErrors(['title']);
});

/** Попытка создания со слишком длинным заголовком */
test('too long name', function () {
    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->page->store(), ['title' => faker()->realTextBetween(256, 300)])->assertSessionHasErrors(['title']);
});

/** Попытка создания со слишком коротким содержимым */
test('too short description', function () {
    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->page->store(), ['content' => 'te'])->assertSessionHasErrors(['content']);
});

/** Успешное создание страницы */
test('success', function () {

    $page = modelBuilderHelper()->page->make();

    authHelper()->signInAsAdmin();

    $response = $this->post(routeBuilderHelper()->page->store(), $page->only('title', 'content'));
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Page was created');

    $response->assertRedirect('/');

    $this->assertDatabaseHas('pages', [
        'title'   => $page->title,
        'content' => $page->content,
    ]);
});

/** Успешное создание страницы с безопасным содержимым */
test('success with safe description', function () {
    $safeContent   = faker()->realText();
    $unsafeContent = '<script>alert("test");</script>' . $safeContent;

    $page = modelBuilderHelper()->page->make(['content' => $unsafeContent]);

    authHelper()->signInAsAdmin();

    $this->post(routeBuilderHelper()->page->store(), $page->only('title', 'content'));

    $this->assertDatabaseHas('pages', [
        'title'   => $page->title,
        'content' => $safeContent,
    ]);
});

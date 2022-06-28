<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка изменения гостем */
test('guest', function () {
    $page = modelBuilderHelper()->page->create();

    $this->put(routeBuilderHelper()->page->update($page->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка изменения пользователем без прав администратора */
test('user', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signIn();

    $this->put(routeBuilderHelper()->page->update($page->id))->assertForbidden();
});

/** Попытка изменения несуществующей страницы */
test('not existed', function () {
    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->page->update(999))->assertNotFound();
});

/** Попытка изменения без данных */
test('empty', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->page->update($page->id))->assertSessionHasErrors(['title', 'content', 'type']);
});

/** Попытка изменения со слишком коротким заголовком */
test('too short name', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->page->update($page->id), ['title' => 'te'])->assertSessionHasErrors(['title']);
});

/** Попытка изменения со слишком длинным заголовком */
test('too long name', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->page->update($page->id), ['title' => faker()->realTextBetween(256, 300)])
        ->assertSessionHasErrors(['title']);
});

/** Попытка изменения со слишком коротким содержимым */
test('too short description', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();

    $this->put(routeBuilderHelper()->page->update($page->id), ['content' => 'te'])->assertSessionHasErrors(['content']);
});

/** Попытка изменения с уже существующим типом */
test('not unique type', function () {
    $page        = modelBuilderHelper()->page->create(['type' => 'welcome']);
    $pageExisted = modelBuilderHelper()->page->create(['type' => 'get-consultation']);

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->page->update($page->id), ['type' => $pageExisted->type])->assertSessionHasErrors(['type']);
});


/** Попытка создания с неправильным типом */
test('wrong type', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->page->update($page->id), ['type' => 'test'])->assertSessionHasErrors(['type']);
});

/** Успешное изменение страницы */
test('success', function () {
    $pageData = modelBuilderHelper()->page->make(['type' => 'get-consultation']);

    $page = modelBuilderHelper()->page->create(['type' => 'welcome']);

    authHelper()->signInAsAdmin();

    $response = $this->put(routeBuilderHelper()->page->update($page->id), $pageData->only('title', 'content', 'type'));
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Page was updated');

    $response->assertRedirect(routeBuilderHelper()->page->view($page->id));

    $this->assertDatabaseHas('pages', [
        'id'      => $page->id,
        'title'   => $pageData->title,
        'content' => $pageData->content,
        'type'    => $pageData->type,
    ]);
});

/** Успешное создание страницы с безопасным содержимым */
test('success with safe description', function () {
    $safeContent   = faker()->realText();
    $unsafeContent = '<script>alert("test");</script>' . $safeContent;

    $updatePage = modelBuilderHelper()->page->make(['content' => $unsafeContent, 'type' => 'welcome']);

    $page = modelBuilderHelper()->page->create(['type' => 'get-consultation']);

    authHelper()->signInAsAdmin();
    $this->put(routeBuilderHelper()->page->update($page->id), $updatePage->only('title', 'content', 'type'));

    $this->assertDatabaseHas('pages', [
        'id'      => $page->id,
        'title'   => $updatePage->title,
        'content' => $safeContent,
    ]);
});

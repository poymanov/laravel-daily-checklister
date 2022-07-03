<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения неавторизованным пользователем */
test('guest', function () {
    $this->get(routeBuilderHelper()->common->home())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Отображение приветственной страницы со стандартным шаблоном */
test('default page', function () {
    authHelper()->signIn();

    $this->get(routeBuilderHelper()->common->home())
        ->assertViewIs('page.welcome.default')
        ->assertSee('Welcome')
        ->assertSee('No information yet.');
});

/** Успешное отображение главной страницы */
test('success', function () {
    $page = modelBuilderHelper()->page->create(['type' => 'welcome']);

    authHelper()->signIn();
    $this->get(routeBuilderHelper()->common->home())
        ->assertViewIs('page.welcome.page')
        ->assertSee($page->title)
        ->assertSee($page->content);
});

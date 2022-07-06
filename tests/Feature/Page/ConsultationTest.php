<?php

use App\Enums\PageTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения неавторизованным пользователем */
test('guest', function () {
    $this->get(routeBuilderHelper()->common->consultation())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Отображение приветственной страницы со стандартным шаблоном */
test('default page', function () {
    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->common->consultation());
    $response->assertViewIs('page.consultation.default');
    $response->assertSee('Consultation');
    $response->assertSee('No information yet.');
});

/** Успешное отображение главной страницы */
test('success', function () {
    $page = modelBuilderHelper()->page->create(['type' => PageTypeEnum::GET_CONSULTATION->value]);

    authHelper()->signIn();
    $response = $this->get(routeBuilderHelper()->common->consultation());

    $response->assertViewIs('page.consultation.page');
    $response->assertSee($page->title);
    $response->assertSee($page->content);
});

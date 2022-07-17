<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $this->get(routeBuilderHelper()->user->index())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка посещения пользователем без прав администратора */
test('user', function () {
    authHelper()->signIn();
    $this->get(routeBuilderHelper()->user->index())->assertForbidden();
});

/** Отображение пользователей */
test('users', function () {
    $userFirst  = modelBuilderHelper()->user->create();
    $userSecond = modelBuilderHelper()->user->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->user->index());

    $response->assertSee($userFirst->name);
    $response->assertSee($userFirst->email);
    $response->assertSee($userFirst->website);
    $response->assertSee($userFirst->created_at);

    $response->assertSee($userSecond->name);
    $response->assertSee($userSecond->email);
    $response->assertSee($userSecond->website);
    $response->assertSee($userSecond->created_at);
});

/** Пользователи с правами администратора не должны отображаться в списке */
test('admin', function () {
    $user = modelBuilderHelper()->user->createAdmin();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->user->index());

    $response->assertDontSee($user->name);
    $response->assertDontSee($user->email);
    $response->assertDontSee($user->website);
    $response->assertDontSee($user->created_at);
});

/** Пользователи отображаются в порядке "последние вначале" */
test('latest', function () {
    $userFirst  = modelBuilderHelper()->user->create();
    $userSecond = modelBuilderHelper()->user->create(['created_at' => Carbon::now()->addDay()]);

    authHelper()->signInAsAdmin();

    $this->get(routeBuilderHelper()->user->index())->assertSeeInOrder([$userSecond->name, $userFirst->name]);
});

/** Пользователи отображаются с учетом пагинации */
test('pagination', function () {
    $userFirst  = modelBuilderHelper()->user->create();
    $userSecond = modelBuilderHelper()->user->create();
    $userThird  = modelBuilderHelper()->user->create();

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->user->index());

    $response->assertSee($userFirst->name);
    $response->assertSee($userSecond->name);
    $response->assertDontSee($userThird->name);
});

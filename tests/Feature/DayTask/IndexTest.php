<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка посещения гостем */
test('guest', function () {
    $response = $this->get(routeBuilderHelper()->dayTask->index());
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Задачи другого пользователя не отображаются */
test('another user', function () {
    $task = modelBuilderHelper()->task->create();

    modelBuilderHelper()->dayTask->create(['task_id' => $task->id]);

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->dayTask->index());
    $response->assertOk();

    $response->assertDontSee($task->name);
});

/** Успешное отображение задач */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->dayTask->create(['task_id' => $task->id, 'user_id' => $user->id]);

    authHelper()->signIn($user);

    $response = $this->get(routeBuilderHelper()->dayTask->index());
    $response->assertOk();

    $response->assertSee($task->name);
    $response->assertSee($task->checklist->name);
});

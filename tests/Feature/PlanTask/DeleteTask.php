<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $planTask = modelBuilderHelper()->planTask->create();

    $response = $this->delete(routeBuilderHelper()->planTask->delete($planTask->task_id));
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления задачи из списка другого пользователя */
test('another user', function () {
    $planTask = modelBuilderHelper()->planTask->create();

    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->planTask->delete($planTask->task_id));
    $response->assertNotFound();
});

/** Попытка удаления несуществующей задачи */
test('not existed task', function () {
    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->planTask->delete(999));
    $response->assertNotFound();
});

/** Попытка удаления задачи, которая не была добавлена в список */
test('not plan task', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->planTask->delete($task->id));
    $response->assertNotFound();
});

/** Успешное удаление задачи из списка */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $planTask = modelBuilderHelper()->planTask->create(['user_id' => $user->id]);

    authHelper()->signIn($user);

    $response = $this->delete(routeBuilderHelper()->planTask->delete($planTask->task_id));
    $response->assertRedirect('/tasks/plan');
    $response->assertSessionHas('alert.success', 'Task was deleted from plan list');

    $this->assertDatabaseMissing('plan_tasks', [
        'id' => $planTask->id,
    ]);
});

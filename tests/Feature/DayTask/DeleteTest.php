<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $dayTask = modelBuilderHelper()->dayTask->create();

    $response = $this->delete(routeBuilderHelper()->dayTask->delete($dayTask->task_id));
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления задачи из списка другого пользователя */
test('another user', function () {
    $dayTask = modelBuilderHelper()->dayTask->create();

    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->dayTask->delete($dayTask->task_id));
    $response->assertNotFound();
});

/** Попытка удаления несуществующей задачи */
test('not existed task', function () {
    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->dayTask->delete(999));
    $response->assertNotFound();
});

/** Попытка удаления задачи, которая не была добавлена в список */
test('not day task', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->dayTask->delete($task->id));
    $response->assertNotFound();
});

/** Успешное удаление задачи из списка */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $dayTask = modelBuilderHelper()->dayTask->create(['user_id' => $user->id]);

    authHelper()->signIn($user);

    $response = $this->delete(routeBuilderHelper()->dayTask->delete($dayTask->task_id));
    $response->assertRedirect('/tasks/day');
    $response->assertSessionHas('alert.success', 'Task was deleted from my day list');

    $this->assertDatabaseMissing('day_tasks', [
        'id' => $dayTask->id,
    ]);
});

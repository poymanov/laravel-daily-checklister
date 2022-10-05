<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $importantTask = modelBuilderHelper()->importantTask->create();

    $response = $this->delete(routeBuilderHelper()->importantTask->delete($importantTask->task_id));
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления задачи из списка другого пользователя */
test('another user', function () {
    $importantTask = modelBuilderHelper()->importantTask->create();

    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->importantTask->delete($importantTask->task_id));
    $response->assertNotFound();
});

/** Попытка удаления несуществующей задачи */
test('not existed task', function () {
    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->importantTask->delete(999));
    $response->assertNotFound();
});

/** Попытка удаления задачи, которая не была добавлена в список */
test('not day task', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->importantTask->delete($task->id));
    $response->assertNotFound();
});

/** Успешное удаление задачи из списка */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $importantTask = modelBuilderHelper()->importantTask->create(['user_id' => $user->id]);

    authHelper()->signIn($user);

    $response = $this->delete(routeBuilderHelper()->importantTask->delete($importantTask->task_id));
    $response->assertRedirect('/tasks/important');
    $response->assertSessionHas('alert.success', 'Task was deleted from important list');

    $this->assertDatabaseMissing('day_tasks', [
        'id' => $importantTask->id,
    ]);
});

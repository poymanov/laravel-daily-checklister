<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Important;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка удаления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Important::class, ['taskId' => $task->id])->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка удаления не добавленной задачи */
test('not added', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    Livewire::test(Important::class, ['taskId' => $task->id])->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Удаление задачи из списка */
test('success', function () {
    $task          = modelBuilderHelper()->task->create();
    $user          = modelBuilderHelper()->user->create();
    $importantTask = modelBuilderHelper()->importantTask->create(['user_id' => $user->id, 'task_id' => $task->id]);

    authHelper()->signIn($user);

    Livewire::test(Important::class, ['taskId' => $task->id])->call('remove')
        ->assertEmitted('updateImportant');

    $this->assertDatabaseMissing('important_tasks', [
        'id'      => $importantTask->id,
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

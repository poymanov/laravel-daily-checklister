<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Important;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка добавления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Important::class, ['taskId' => $task->id])->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка добавления уже добавленной задачи */
test('already added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();
    modelBuilderHelper()->importantTask->create(['user_id' => $user->id, 'task_id' => $task->id]);

    authHelper()->signIn($user);

    Livewire::test(Important::class, ['taskId' => $task->id])->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Добавление задачи в список */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Important::class, ['taskId' => $task->id])->call('add')
        ->assertEmitted('updateImportant');

    $this->assertDatabaseHas('important_tasks', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

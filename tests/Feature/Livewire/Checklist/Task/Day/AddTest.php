<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Day;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка добавления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Day::class, ['taskId' => $task->id])->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка добавления уже добавленной задачи */
test('already added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();
    modelBuilderHelper()->dayTask->create(['user_id' => $user->id, 'task_id' => $task->id]);

    authHelper()->signIn($user);

    Livewire::test(Day::class, ['taskId' => $task->id])->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Добавление задачи в список */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Day::class, ['taskId' => $task->id])->call('add')->assertEmitted('updateMyDay');

    $this->assertDatabaseHas('day_tasks', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

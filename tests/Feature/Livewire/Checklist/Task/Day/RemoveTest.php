<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Day;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка удаления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Day::class, ['taskId' => $task->id])->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка удаления не добавленной задачи */
test('not added', function () {
    $task = modelBuilderHelper()->task->create();

    authHelper()->signIn();

    Livewire::test(Day::class, ['taskId' => $task->id])->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Удаление задачи из списка */
test('success', function () {
    $task    = modelBuilderHelper()->task->create();
    $user    = modelBuilderHelper()->user->create();
    $dayTask = modelBuilderHelper()->dayTask->create(['user_id' => $user->id, 'task_id' => $task->id]);

    authHelper()->signIn($user);

    Livewire::test(Day::class, ['taskId' => $task->id])->call('remove')->assertEmitted('updateMyDay');

    $this->assertDatabaseMissing('day_tasks', [
        'id'      => $dayTask->id,
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

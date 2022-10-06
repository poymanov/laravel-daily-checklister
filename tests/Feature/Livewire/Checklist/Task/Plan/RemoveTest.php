<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка удаления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Plan::class, ['taskId' => $task->id])
        ->set('plannedDate', now())
        ->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка удаления не добавленной задачи */
test('not added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Plan::class, ['taskId' => $task->id])
        ->set('plannedDate', now())
        ->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Удаление задачи из списка */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    $planTask = modelBuilderHelper()->planTask->create(['user_id' => $user->id, 'task_id' => $task->id]);

    authHelper()->signIn($user);

    Livewire::test(Plan::class, ['taskId' => $task->id])
        ->set('plannedDate', $planTask->date)
        ->call('remove')
        ->assertEmitted('updatePlan');

    $this->assertDatabaseMissing('plan_tasks', [
        'id'      => $planTask->id,
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

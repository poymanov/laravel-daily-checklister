<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка добавления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Plan::class, ['taskId' => $task->id])
        ->set('plannedDate', now())
        ->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка добавления уже добавленной задачи */
test('already added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->planTask->create(['user_id' => $user->id, 'task_id' => $task->id]);

    authHelper()->signIn($user);

    Livewire::test(Plan::class, ['taskId' => $task->id])
        ->set('plannedDate', now())
        ->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Добавление задачи в список */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Plan::class, ['taskId' => $task->id])
        ->set('plannedDate', now())
        ->call('add')
        ->assertEmitted('updatePlan');

    $this->assertDatabaseHas('plan_tasks', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

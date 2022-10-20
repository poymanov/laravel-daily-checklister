<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Remind;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка добавления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Remind::class, ['taskId' => $task->id])
        ->set('remindDate', now()->toDateString())
        ->set('remindTime', now()->toTimeString())
        ->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка добавления уже добавленной задачи */
test('already added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();
    modelBuilderHelper()->remindTask->create(
        ['user_id' => $user->id, 'task_id' => $task->id]
    );

    authHelper()->signIn($user);

    Livewire::test(Remind::class, ['taskId' => $task->id])
        ->set('remindDate', now()->toDateString())
        ->set('remindTime', now()->toTimeString())
        ->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Добавление напоминания для задачи */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();
    $text = faker()->text;

    authHelper()->signIn($user);

    Livewire::test(Remind::class, ['taskId' => $task->id])
        ->set('remindDate', now()->toDateString())
        ->set('remindTime', now()->toTimeString())
        ->call('add');

    $this->assertDatabaseHas('remind_tasks', [
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Remind;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка удаления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Remind::class, ['taskId' => $task->id])
        ->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка удаления не добавленного напоминания */
test('not added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Remind::class, ['taskId' => $task->id])
        ->call('remove')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Удаление напоминания */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    $taskNote = modelBuilderHelper()->taskNote->create(
        ['user_id' => $user->id, 'task_id' => $task->id, 'text' => faker()->text]
    );

    authHelper()->signIn($user);

    Livewire::test(Remind::class, ['taskId' => $task->id])->call('remove');

    $this->assertDatabaseMissing('remind_tasks', [
        'id'      => $taskNote->id,
        'user_id' => $user->id,
        'task_id' => $task->id,
    ]);
});

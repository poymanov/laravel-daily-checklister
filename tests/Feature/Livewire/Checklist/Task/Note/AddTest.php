<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка добавления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Note::class, ['taskId' => $task->id])
        ->set('textareaText', faker()->text)
        ->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка добавления уже добавленной задачи */
test('already added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();
    modelBuilderHelper()->taskNote->create(
        ['user_id' => $user->id, 'task_id' => $task->id, 'text' => faker()->text]
    );

    authHelper()->signIn($user);

    Livewire::test(Note::class, ['taskId' => $task->id])->call('add')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Добавление заметки для задачи */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();
    $text = faker()->text;

    authHelper()->signIn($user);

    Livewire::test(Note::class, ['taskId' => $task->id])
        ->set('textareaText', $text)
        ->call('add');

    $this->assertDatabaseHas('task_notes', [
        'user_id' => $user->id,
        'task_id' => $task->id,
        'text' => $text
    ]);
});

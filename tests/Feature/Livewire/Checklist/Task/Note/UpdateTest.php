<?php

declare(strict_types=1);

use App\Http\Livewire\Task\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка обновления неавторизованным пользователем */
test('guest', function () {
    $task = modelBuilderHelper()->task->create();

    Livewire::test(Note::class, ['taskId' => $task->id])
        ->set('textareaText', faker()->text)
        ->call('update')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Попытка обновления не добавленной заметки */
test('not added', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Note::class, ['taskId' => $task->id])
        ->set('textareaText', faker()->text)
        ->call('update')
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Обновление заметки */
test('success', function () {
    $task = modelBuilderHelper()->task->create();
    $user = modelBuilderHelper()->user->create();

    modelBuilderHelper()->taskNote->create(
        ['user_id' => $user->id, 'task_id' => $task->id, 'text' => faker()->text]
    );

    authHelper()->signIn($user);

    $newText = faker()->text;

    Livewire::test(Note::class, ['taskId' => $task->id])
        ->set('textareaText', $newText)
        ->call('update');

    $this->assertDatabaseHas('task_notes', [
        'user_id' => $user->id,
        'task_id' => $task->id,
        'text'    => $newText,
    ]);
});

<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка отмены завершения несуществующей задачи */
test('not existed task', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $user      = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])
        ->call('incomplete', 999)
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Успешная отмена завершения задачи */
test('success', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);
    $user      = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])
        ->call('incomplete', $task->id)
        ->assertEmitted('changeTaskCompleteStatus', $task->checklist->id);

    $this->assertDatabaseHas('tasks', [
        'id'           => $task->id,
        'completed_by' => null,
        'completed_at' => null,
    ]);
});

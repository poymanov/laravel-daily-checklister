<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка завершения несуществующей задачи */
test('not existed task', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $user           = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])
        ->call('complete', 999)
        ->assertRedirect('/')
        ->assertSessionHas('alert.error');
});

/** Успешное завершение задачи */
test('success', function () {
    $checklist = modelBuilderHelper()->checklist->create();
    $task      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);
    $user      = modelBuilderHelper()->user->create();

    authHelper()->signIn($user);

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])->call('complete', $task->id);

    $this->assertDatabaseHas('tasks', [
        'id'           => $task->id,
        'completed_by' => $user->id,
    ]);

    $this->assertDatabaseMissing('tasks', [
        'id'           => $task->id,
        'completed_at' => null,
    ]);
});

<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка изменения порядка сортировки несуществующей задачи */
test('not existed', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signIn();

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])
        ->call('moveNext', 999)
        ->assertSessionHas('alert.error')
        ->assertRedirect('/');
});

/** Успешное перемещение на следующую позицию в порядке сортировки */
test('success', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    $taskFirst  = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 1]);
    $taskSecond = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 2]);

    authHelper()->signIn();

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])->call('moveNext', $taskFirst->id);

    $this->assertDatabaseHas('tasks', [
        'id'    => $taskFirst->id,
        'order' => 2,
    ]);

    $this->assertDatabaseHas('tasks', [
        'id'    => $taskSecond->id,
        'order' => 1,
    ]);
});

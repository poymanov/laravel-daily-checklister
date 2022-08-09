<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Перемещение на предыдущую позицию в порядке сортировки */
test('move prev', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    $taskFirst  = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 1]);
    $taskSecond = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 2]);

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])->call('movePrev', $taskSecond->id);

    $this->assertDatabaseHas('tasks', [
        'id'    => $taskFirst->id,
        'order' => 2,
    ]);

    $this->assertDatabaseHas('tasks', [
        'id'    => $taskSecond->id,
        'order' => 1,
    ]);
});

/** Перемещение на следующую позицию в порядке сортировки */
test('move next', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    $taskFirst  = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 1]);
    $taskSecond = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id, 'order' => 2]);

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

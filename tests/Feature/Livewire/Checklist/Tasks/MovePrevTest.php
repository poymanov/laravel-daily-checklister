<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

/** Попытка изменения порядка сортировки несуществующей задачи */
test('not existed', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    Livewire::test(Tasks::class, ['checklistId' => $checklist->id])
        ->call('movePrev', 999)
        ->assertSessionHas('alert.error')
        ->assertRedirect('/');
});

/** Успешное перемещение на предыдущую позицию в порядке сортировки */
test('success', function () {
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

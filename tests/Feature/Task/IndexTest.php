<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\Tasks;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Успешный просмотр списка задач для пользователя */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $taskFirst  = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);
    $taskSecond = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signIn();
    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();
    $response->assertSeeLivewire(Tasks::class);

    $response->assertSee('Tasks');
    $response->assertSee($taskFirst->name);
    $response->assertSee($taskSecond->name);
    $response->assertDontSee('Create Task');
});

/** Успешный просмотр списка задач для администратор */
test('admin', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $taskFirst      = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);
    $taskSecond     = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();
    $response->assertSeeLivewire(Tasks::class);

    $response->assertSee('Tasks');
    $response->assertSee('Create Task');
    $response->assertSee($taskFirst->name);
    $response->assertSee($taskSecond->name);
});

/** Задачи другого чеклиста не отображаются */
test('another сhecklist', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $task           = modelBuilderHelper()->task->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();

    $response->assertDontSee($task->name);
});

<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Успешный просмотр списка задач */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist  = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $taskFirst  = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);
    $taskSecond = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();

    $response->assertSee('Tasks');
    $response->assertSee('Create Task');
    $response->assertSee($taskFirst->name);
    $response->assertSee($taskSecond->name);
});

/** Задачи другого чеклиста не отображаются */
test('another сhecklist', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist  = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $task  = modelBuilderHelper()->task->create();

    authHelper()->signInAsAdmin();
    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();

    $response->assertDontSee($task->name);
});

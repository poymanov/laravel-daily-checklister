<?php

declare(strict_types=1);

use App\Http\Livewire\Checklist\ChecklistTopItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка просмотра гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка просмотра с несуществующей группой */
test('not existed group', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signIn();
    $response = $this->get(routeBuilderHelper()->checklist->view(999, $checklist->id));
    $response->assertNotFound();
});

/** Попытка просмотра несуществующего объекта */
test('not existed', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signIn();
    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, 999));
    $response->assertNotFound();
});

/** Успешное открытие страницы просмотра пользователем */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signIn();

    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();

    $response->assertSee($checklist->name);
    $response->assertDontSee('Edit');
    $response->assertDontSee('Delete');
    $response->assertDontSee('Create Task');
});

/** Успешное открытие страницы просмотра администратором */
test('admin', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signInAsAdmin();

    $response = $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));
    $response->assertOk();

    $response->assertSee($checklist->name);
    $response->assertSee('Edit');
    $response->assertSee('Delete');
    $response->assertSee('Tasks');
    $response->assertSee('Create Task');
});

/** Отображение компонента с топ-чеклистом */
test('top', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    modelBuilderHelper()->checklist->create(['is_top' => true]);

    authHelper()->signIn();
    $this->get(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id))->assertSeeLivewire(ChecklistTopItem::class);
});

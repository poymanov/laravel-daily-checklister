<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $checklist      = modelBuilderHelper()->checklist->create();
    $task           = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    $this
        ->delete(routeBuilderHelper()->task->delete($checklist->id, $task->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления пользователем без прав администратора */
test('user', function () {
    $checklist      = modelBuilderHelper()->checklist->create();
    $task           = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signIn();

    $this
        ->delete(routeBuilderHelper()->task->delete($checklist->id, $task->id))
        ->assertForbidden();
});

/** Попытка удаления задачи для несуществующего чеклиста */
test('not existed checklist', function () {
    $task           = modelBuilderHelper()->task->create();

    authHelper()->signInAsAdmin();

    $this->delete(routeBuilderHelper()->task->delete(999, $task->id))->assertNotFound();
});

/** Попытка удаления несуществующей задачи */
test('not existed', function () {
    $checklist      = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();

    $this->delete(routeBuilderHelper()->task->delete($checklist->id, 999))->assertNotFound();
});

/** Успешное удаление */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);
    $task           = modelBuilderHelper()->task->create(['checklist_id' => $checklist->id]);

    authHelper()->signInAsAdmin();
    $response = $this->delete(routeBuilderHelper()->task->delete($checklist->id, $task->id));

    $response->assertSessionHas('alert.success', 'Task was deleted');

    $response->assertRedirect(routeBuilderHelper()->checklist->view($checklistGroup->id, $checklist->id));

    $this->assertDatabaseMissing('tasks', [
        'id'           => $task->id,
        'checklist_id' => $checklist->id,
        'deleted_at'   => null,
    ]);
});

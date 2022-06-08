<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    $this
        ->delete(routeBuilderHelper()->checklist->delete($checklist->group->id, $checklist->id))
        ->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления пользователем без прав администратора */
test('user', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signIn();
    $this->delete(routeBuilderHelper()->checklist->delete($checklist->group->id, $checklist->id))->assertForbidden();
});

/** Попытка удаления элемента с несуществующей группой */
test('not existed group', function () {
    $checklist = modelBuilderHelper()->checklist->create();

    authHelper()->signInAsAdmin();
    $this->delete(routeBuilderHelper()->checklist->delete(999, $checklist->id))->assertNotFound();
});

/** Попытка удаления несуществующего элемента */
test('not existed', function () {
    $group = modelBuilderHelper()->checklistGroup->create();

    authHelper()->signInAsAdmin();
    $this->delete(routeBuilderHelper()->checklist->delete($group->id, 999))->assertNotFound();
});

/** Успешное удаление */
test('success', function () {
    $checklistGroup = modelBuilderHelper()->checklistGroup->create();
    $checklist      = modelBuilderHelper()->checklist->create(['checklist_group_id' => $checklistGroup->id]);

    authHelper()->signInAsAdmin();
    $response = $this->delete(routeBuilderHelper()->checklist->delete($checklistGroup->id, $checklist->id));

    $response->assertSessionHas('alert.success', 'Checklist was deleted');

    $response->assertRedirect('/');

    $this->assertDatabaseMissing('checklists', [
        'id'         => $checklist->id,
        'deleted_at' => null,
    ]);
});

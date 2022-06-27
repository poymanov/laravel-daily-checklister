<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $page = modelBuilderHelper()->page->create();

    $this->delete(routeBuilderHelper()->page->delete($page->id))->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления пользователем без прав администратора */
test('user', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signIn();

    $this->delete(routeBuilderHelper()->page->delete($page->id))->assertForbidden();
});

/** Попытка удаления несуществующего объекта */
test('not existed', function () {
    authHelper()->signInAsAdmin();

    $this->delete(routeBuilderHelper()->page->delete(999))->assertNotFound();
});

/** Успешное удаление */
test('success', function () {
    $page = modelBuilderHelper()->page->create();

    authHelper()->signInAsAdmin();
    $response = $this->delete(routeBuilderHelper()->page->delete($page->id));

    $response->assertSessionHas('alert.success', 'Page was deleted');

    $response->assertRedirect('/');

    $this->assertDatabaseMissing('tasks', [
        'id'         => $page->id,
        'deleted_at' => null,
    ]);
});

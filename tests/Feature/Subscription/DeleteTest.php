<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/** Попытка удаления гостем */
test('guest', function () {
    $response = $this->delete(routeBuilderHelper()->subscription->delete());
    $response->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка удаления администратором */
test('admin', function () {
    authHelper()->signInAsAdmin();

    $response = $this->delete(routeBuilderHelper()->subscription->delete());
    $response->assertRedirect(routeBuilderHelper()->common->home());
});

/** Попытка удаления подписки при её отсутствии */
test('not existed', function () {
    authHelper()->signIn();

    $response = $this->delete(routeBuilderHelper()->subscription->delete());
    $response->assertSessionHas('alert.error', 'Failed to cancel subscription');
});

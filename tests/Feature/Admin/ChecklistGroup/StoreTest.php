<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Faker\faker;

uses(RefreshDatabase::class);

/** Попытка создания гостем */
test('guest', function () {
    $this->post(routeBuilderHelper()->checklistGroup->common())->assertRedirect(routeBuilderHelper()->auth->login());
});

/** Попытка создания пользователем без прав администратора */
test('user', function () {
    authHelper()->signIn();
    $this->post(routeBuilderHelper()->checklistGroup->common())->assertForbidden();
});

/** Попытка создания без данных */
test('empty', function () {
    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->checklistGroup->common())->assertSessionHasErrors(['name']);
});


/** Попытка создания группы с неуникальным названием */
test('not unique name', function () {
    $name = faker()->word();
    modelBuilderHelper()->checklistGroup->create(['name' => $name]);

    authHelper()->signInAsAdmin();
    $this->post(routeBuilderHelper()->checklistGroup->common(), ['name' => $name])->assertSessionHasErrors(['name']);
});


/** Успешное создание */
test('success', function () {
    $name = faker()->word();

    authHelper()->signInAsAdmin();

    $response = $this->post(routeBuilderHelper()->checklistGroup->common(), ['name' => $name]);
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('alert.success', 'Checklist group was created');

    $response->assertRedirect(routeBuilderHelper()->common->home());

    $this->assertDatabaseHas('checklist_groups', [
        'name' => $name,
    ]);
});

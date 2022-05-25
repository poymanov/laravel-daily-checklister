<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Enums\RoleEnum;
use App\Models\ChecklistGroup;
use App\Models\User;

uses(Tests\TestCase::class)->in('Feature');

const HOME_URL                         = '/';
const LOGIN_URL                        = '/login';
const CONFIRM_PASSWORD_URL             = '/confirm-password';
const FORGOT_PASSWORD_URL              = '/forgot-password';
const RESET_PASSWORD_URL               = '/reset-password';
const REGISTER_URL                     = '/register';
const ADMIN_CHECKLIST_GROUP_CREATE_URL = '/admin/checklist-group/create';
const ADMIN_CHECKLIST_GROUP_URL        = '/admin/checklist-group';

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

/**
 * @param null $user
 */
function signIn($user = null): void
{
    $user = $user ?: createUser();
    test()->actingAs($user);
}

/**
 * Создание сущности {@see User}
 *
 * @param array $params  Параметры нового объекта
 * @param bool  $isAdmin Является ли пользователь администратором
 *
 * @return User
 */
function createUser(array $params = [], bool $isAdmin = false): User
{
    $user = User::factory()->create($params);

    if ($isAdmin) {
        $user->assignRole(RoleEnum::ADMIN->value);
    }

    return $user;
}

/**
 * Создание сущности {@see ChecklistGroup}
 *
 * @param array $params Параметры нового объекта
 *
 * @return ChecklistGroup
 */
function createChecklistGroup(array $params = []): ChecklistGroup
{
    return ChecklistGroup::factory()->create($params);
}

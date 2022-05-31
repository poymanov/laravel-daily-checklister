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

use Tests\Helpers\AuthHelper;
use Tests\Helpers\ModelBuilderHelper;
use Tests\Helpers\RouteBuilderHelper;

uses(Tests\TestCase::class)->in('Feature');

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
 * @return AuthHelper
 */
function authHelper(): AuthHelper
{
    return AuthHelper::getInstance(modelBuilderHelper());
}

/**
 * @return ModelBuilderHelper
 */
function modelBuilderHelper(): ModelBuilderHelper
{
    return ModelBuilderHelper::getInstance();
}

/**
 * @return RouteBuilderHelper
 */
function routeBuilderHelper(): RouteBuilderHelper
{
    return RouteBuilderHelper::getInstance();
}

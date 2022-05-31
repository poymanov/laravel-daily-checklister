<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Psy\Command\ExitCommand;
use Symfony\Component\Console\Exception\RuntimeException;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

/** Выполнение команды без указания email пользователя */
test('without email', function () {
    $this->expectException(RuntimeException::class);
    $this->expectDeprecationMessage('Not enough arguments (missing: "email")');

    $this->artisan('users:assign-admin-role')->assertExitCode(ExitCommand::FAILURE);
});

/** Указанный пользователь не существует */
test('user not existed', function () {
    $notExistedEmail = 'test@test.ru';

    $this->artisan('users:assign-admin-role ' . $notExistedEmail)
        ->expectsOutput('User not found: ' . $notExistedEmail)
        ->assertExitCode(ExitCommand::FAILURE);
});

/** Успешное назначение роли */
test('success', function () {
    $user = modelBuilderHelper()->user->create();

    $this->artisan('users:assign-admin-role ' . $user->email)
        ->expectsOutput('Success')
        ->assertExitCode(ExitCommand::SUCCESS);
});

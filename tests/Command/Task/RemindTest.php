<?php

use App\Notifications\RemindTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Psy\Command\ExitCommand;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

/** Напоминания не отправляются при их отсутствии */
test('without email', function () {
    Notification::fake();

    $this->artisan('tasks:remind')
        ->expectsOutput('Empty')
        ->assertExitCode(ExitCommand::SUCCESS);

    Notification::assertNothingSent();
});

/** Более поздние уведомления не должны быть отправлены в текущий момент */
test('test future', function () {
    Notification::fake();

    modelBuilderHelper()->remindTask->create(['date' => now()->addMinute()]);

    $this->artisan('tasks:remind')
        ->expectsOutput('Success')
        ->assertExitCode(ExitCommand::SUCCESS);

    Notification::assertNothingSent();
});

/** Успешная отправка уведомления */
test('success', function () {
    Notification::fake();

    $user   = modelBuilderHelper()->user->create();
    $remind = modelBuilderHelper()->remindTask->create(['user_id' => $user->id, 'date' => now()->subMinute()]);

    $this->artisan('tasks:remind')
        ->expectsOutput('Success')
        ->assertExitCode(ExitCommand::SUCCESS);

    Notification::assertSentTo($user, RemindTask::class);

    $this->assertDatabaseMissing('remind_tasks', [
        'id' => $remind->id,
    ]);
});

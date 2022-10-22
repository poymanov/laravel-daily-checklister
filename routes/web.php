<?php

use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistGroupController;
use App\Http\Controllers\DayTaskController;
use App\Http\Controllers\ImportantTaskController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PlanTaskController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::group(['as' => 'page.'], function () {
        Route::get('/', [PageController::class, 'welcome'])->name('welcome');
        Route::get('/get-consultation', [PageController::class, 'consultation'])->name('consultation');
    });

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('checklist-groups', ChecklistGroupController::class)->except('show', 'index');
        Route::resource('checklists.tasks', TaskController::class)->except('index');
    });

    Route::resource('checklist-groups.checklists', ChecklistController::class)->except('index');

    Route::group(['middleware' => ['role:admin'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::resource('pages', AdminPageController::class)->except('index');
    });

    Route::group(['prefix' => 'subscription', 'as' => 'subscription.', 'middleware' => ['role.not:admin']], function () {
        Route::get('', [SubscriptionController::class, 'index'])->name('index');
        Route::post('', [SubscriptionController::class, 'store'])->name('store');
        Route::delete('', [SubscriptionController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::group(['prefix' => 'day', 'as' => 'day.'], function () {
            Route::get('/', [DayTaskController::class, 'index'])->name('index');
            Route::delete('/{task}', [DayTaskController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'important', 'as' => 'important.'], function () {
            Route::get('/', [ImportantTaskController::class, 'index'])->name('index');
            Route::delete('/{task}', [ImportantTaskController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'plan', 'as' => 'plan.'], function () {
            Route::get('/', [PlanTaskController::class, 'index'])->name('index');
            Route::delete('/{task}', [PlanTaskController::class, 'destroy'])->name('destroy');
        });
    });

    Route::post('/upload-image', [UploadController::class, 'upload'])->name('upload-image');
});

require __DIR__ . '/auth.php';

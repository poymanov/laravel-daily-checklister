<?php

use App\Http\Controllers\Admin\ChecklistController;
use App\Http\Controllers\Admin\ChecklistGroupController;
use App\Http\Controllers\Admin\TaskController;
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
    Route::view('/', 'dashboard')->name('dashboard');

    Route::group(['middleware' => ['role:admin'], 'as' => 'admin.', 'prefix' => 'admin'], function () {
        Route::resource('checklist-groups', ChecklistGroupController::class)->except('show', 'index');
        Route::resource('checklist-groups.checklists', ChecklistController::class)->except('index');
        Route::resource('checklists.tasks', TaskController::class)->except('index');
    });
});

require __DIR__ . '/auth.php';

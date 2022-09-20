<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\DayTask\Contracts\DayTaskServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Throwable;

class DayTaskController extends Controller
{
    public function __construct(private readonly DayTaskServiceContract $dayTaskService)
    {
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $dayTasks = $this->dayTaskService->findAllByUserId((int) auth()->id());

        return view('day-task.index', compact('dayTasks'));
    }

    /**
     * @param Task $task
     *
     * @return RedirectResponse
     */
    public function destroy(Task $task)
    {
        if (!$this->dayTaskService->isExists($task->id, (int) auth()->id())) {
            abort(Response::HTTP_NOT_FOUND);
        }

        try {
            $this->dayTaskService->remove($task->id, (int) auth()->id());

            return redirect()->route('tasks.day.index')->with('alert.success', 'Task was deleted from my day list');
        } catch (Throwable) {
            return redirect()->back()->with('alert.error', 'Failed to delete task from my day list');
        }
    }
}

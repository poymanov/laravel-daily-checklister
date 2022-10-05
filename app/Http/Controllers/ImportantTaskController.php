<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\ImportantTask\Contracts\ImportantTaskServiceContract;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Throwable;

class ImportantTaskController extends Controller
{
    public function __construct(private readonly ImportantTaskServiceContract $importantTaskService)
    {
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $importantTasks = $this->importantTaskService->findAllByUserId((int)auth()->id());

        return view('important-task.index', compact('importantTasks'));
    }

    /**
     * @param Task $task
     *
     * @return RedirectResponse
     */
    public function destroy(Task $task)
    {
        if (!$this->importantTaskService->isExists($task->id, (int)auth()->id())) {
            abort(Response::HTTP_NOT_FOUND);
        }

        try {
            $this->importantTaskService->remove($task->id, (int)auth()->id());

            return redirect()->route('tasks.important.index')->with('alert.success', 'Task was deleted from important list');
        } catch (Throwable) {
            return redirect()->back()->with('alert.error', 'Failed to delete task from important list');
        }
    }
}
